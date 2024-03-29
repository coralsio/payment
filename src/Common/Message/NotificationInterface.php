<?php

namespace Corals\Modules\Payment\Common\Message;

/**
 * Incoming notification
 */
interface NotificationInterface extends MessageInterface
{
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_PENDING = 'pending';
    public const STATUS_FAILED = 'failed';

    /**
     * Gateway Reference
     *
     * @return string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference();

    /**
     * Was the transaction successful?
     *
     * @return string Transaction status, one of {@see STATUS_COMPLETED}, {@see #STATUS_PENDING},
     * or {@see #STATUS_FAILED}.
     */
    public function getTransactionStatus();

    /**
     * Response Message
     *
     * @return string A response message from the payment gateway
     */
    public function getMessage();
}
