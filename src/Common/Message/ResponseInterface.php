<?php
/**
 * Response interface
 */

namespace Corals\Modules\Payment\Common\Message;

/**
 * Response Interface
 *
 * This interface class defines the standard functions that any Payment response
 * interface needs to be able to provide.  It is an extension of MessageInterface.
 *
 * @see MessageInterface
 */
interface ResponseInterface extends MessageInterface
{
    /**
     * Get the original request which generated this response
     *
     * @return RequestInterface
     */
    public function getRequest();

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful();

    /**
     * Does the response require a redirect?
     *
     * @return bool
     */
    public function isRedirect();

    /**
     * Is the transaction cancelled by the user?
     *
     * @return bool
     */
    public function isCancelled();

    /**
     * Response Message
     *
     * @return null|string A response message from the payment gateway
     */
    public function getMessage();

    /**
     * Response code
     *
     * @return null|string A response code from the payment gateway
     */
    public function getCode();

    /**
     * Gateway Reference
     *
     * @return null|string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference();
}
