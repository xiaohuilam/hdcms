<?php
/** .-------------------------------------------------------------------
 * |    Author: 向军 <www.aoxiangjun.com>
 * |    WeChat: houdunren2018
 * |      Date: 2019-02-23
 * | Copyright (c) 2012-2019, www.houdunren.com. All Rights Reserved.
 * '-------------------------------------------------------------------*/

namespace App\Servers;

/**
 * 微信处理服务
 * Class ChatServer
 * @package App\Servers
 */
class ChatServer
{
    /**
     * 保存关键词数据
     * @param $model
     * @return bool
     * @throws \Exception
     */
    public function save($model)
    {
        $this->validate($model);
        $model->keyword()->updateOrCreate(['id' => $model->keyword['id']], request()->input('keyword'));
        return true;
    }

    /**
     * 表单验证
     * @param $model
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validate($model)
    {
        $keyword = request()->input('keyword');
        \Validator::make($keyword, [
            'key' => [
                'required',
                'unique:keywords,key,' . $model['keyword']['id'] ?? null,
            ],
        ], ['key.required' => '关键词不能为空', 'key.unique' => '关键词已经在公众号中被使用'])->validate();
    }
}