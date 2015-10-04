<?php

namespace tourze\View;

use Exception;
use tourze\Base\Base as TourzeBase;

/**
 * 原生php的视图处理类
 *
 * @package tourze\View
 */
class View extends Base implements ViewInterface
{

    /**
     * {@inheritdoc}
     */
    protected function capture($viewFilename, array $viewData)
    {
        TourzeBase::getLog()->debug(__METHOD__ . ' capture view output', [
            'file' => $viewFilename,
        ]);

        // 导入变量
        extract($viewData, EXTR_SKIP);
        if ( ! empty(View::$_globalData))
        {
            extract(View::$_globalData, EXTR_SKIP | EXTR_REFS);
        }

        ob_start();
        try
        {
            include $viewFilename;
        }
        catch (Exception $e)
        {
            ob_end_clean();
            throw $e;
        }

        // 获取最终内容
        return ob_get_clean();
    }
}
