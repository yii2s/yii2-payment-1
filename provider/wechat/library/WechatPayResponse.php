<?php

/***************************************************************************
 *
 * Copyright (c) 2016 Lubanr.com All Rights Reserved
 *
 **************************************************************************/
 
namespace lubaogui\payment\provider\wechat\library;
 
 
use Yii;
/**
 * @file WechatPayResponse.php
 * @author 吕宝贵(lbaogui@lubanr.com)
 * @date 2016/03/03 18:00:59
 * @version $Revision$
 * @brief
 *
 **/

class WechatPayResponse extends WechatPayBase {


    public function __construct($xml, $scenario = 'unifiedOrder') {
        if ($xml) {
            $data = $this->transferXmlToArray($xml);
            if (!is_array($data)) {
                $this->addError('debug', __METHOD__ . ':服务器返回xml不可解析:' . $xml);
                return false;
            }
            else {
                $this->setScenario($scenario);
                Yii::warning('支付服务器return结果为:-----------------------');
                Yii::warning($data);
                $this->setAttributes($data, false);
                Yii::warning($this->toArray());
                if ($this->getAttribute('return_code') !== 'SUCCESS') {
                    $this->addError(__METHOD__, $this->getAttribute('return_msg'));
                }
                else {
                    if ($this->getAttribute('result_code') !== 'SUCCESS') {
                        $this->addError(__METHOD__, $this->getAttribute('err_code_desc'));
                    }
                }
            }
        }
        else {
            $this->addError(__METHOD__, '服务器返回为空');
            return false;
        }
    }

    public function scenarios() {
        return [
            'unifiedOrder'=>[
                'return_code', 'return_msg', 'appid', 'mch_id', 'device_info', 'nonce_str', 
                'sign', 'result_code', 'err_code', 'err_code_desc', 'trade_type', 'prepay_id',
                'code_url'
            ],
            'query'=>[
                'return_code', 'return_msg', 'appid', 'mch_id', 'device_info', 'nonce_str', 
                'sign', 'result_code', 'err_code', 'err_code_desc', 'trade_type', 'prepay_id',
                'code_url', 'trade_state', 'total_fee'
            ],
        ];
    }


}





/* vim: set et ts=4 sw=4 sts=4 tw=100: */
