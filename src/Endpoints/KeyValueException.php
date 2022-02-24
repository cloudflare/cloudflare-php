<?php

namespace Cloudflare\API\Endpoints;

use Throwable;

class KeyValueException extends EndpointException
{
    protected $codeMessageMap = [
        10001 => 'service temporarily unavailable',
        10002 => 'missing CF-Ray header',
        10003 => 'missing account public ID',
        10004 => 'missing account tag',
        10005 => 'URL parameter account tag does not match JWT account tag',
        10006 => 'malformed account tag',
        10007 => 'malformed page argument',
        10008 => 'malformed per_page argument',
        10009 => 'key not found',
        10010 => 'malformed namespace',
        10011 => 'malformed namespace ID',
        10012 => 'malformed value',
        10013 => 'namespace not found',
        10014 => 'namespace already exists',
        10015 => 'missing account internal ID',
        10016 => 'malformed account internal ID',
        10018 => 'too many namespaces in this account',
        10019 => 'missing title',
        10021 => 'this namespace does not support the list-keys endpoint',
        10022 => 'too many requests',
        10024 => 'payload too large',
        10025 => 'endpoint does not exist',
        10026 => 'not entitled',
        10028 => 'invalid limit argument',
        10029 => 'invalid request',
        10030 => 'key too long',
        10033 => 'invalid expiration',
        10034 => 'invalid expiration ttl',
        10035 => 'this namespace does not support the bulk endpoint',
        10037 => 'the user lacks the permissions to perform this operation',
        10038 => 'this namespace does not support the list-keys prefix parameter',
        10041 => 'invalid "list keys" cursor',
        10042 => 'illegal key name',
        10043 => 'invalid order',
        10044 => 'invalid direction',
        10045 => 'deprecated endpoint',
        10046 => 'too many bulk requests',
        10047 => 'invalid metadata',
        10048 => 'free limit reached'
    ];

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if (empty($message) && isset($this->codeMessageMap[$code])) {
            $message = $this->codeMessageMap[$code];
        }

        parent::__construct($message, $code, $previous);
    }

}
