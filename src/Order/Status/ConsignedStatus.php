<?php

namespace Codeages\Biz\Framework\Order\Status;

class ConsignedStatus extends AbstractStatus
{
    const NAME = 'consigned';

    public function getPriorStatus()
    {
        return array(PaidStatus::NAME);
    }

    public function finish()
    {
        $finishTime = time();
        $order = $this->getOrderDao()->update($this->order['id'], array(
            'status' => FinishStatus::NAME,
            'finish_time' => $finishTime
        ));

        $items = $this->getOrderItemDao()->findByOrderId($this->order['id']);
        foreach ($items as $item) {
            $this->getOrderItemDao()->update($item['id'], array(
                'status' => FinishStatus::NAME,
                'finish_time' => $finishTime
            ));
        }
        return $order;
    }
}