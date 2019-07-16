<?php declare(strict_types=1);

namespace MyENA\RGW\Chain;

use MyENA\RGW\AbstractLink;
use MyENA\RGW\Chain\Usage\Info;
use MyENA\RGW\Links\HeaderLink;
use MyENA\RGW\Links\UriLink;

/**
 * Class User
 * @package MyENA\RGW\Chain
 */
class UsageRootLink extends AbstractLink implements UriLink, HeaderLink
{
    const PATH = '/usage';

    /**
     * @return string
     */
    public function getUriPart(): string
    {
        return self::PATH;
    }

    /**
     * @return array
     */
    public function getRequestHeaders(): array
    {
        return RGW_DEFAULT_REQUEST_HEADERS;
    }
    
    /**
     * @param string $uid
     * @return \MyENA\RGW\Chain\Usage\Info
     */
    public function Info(string $uid, ?bool $entries = null, ?bool $summary = null, string $start = null, string $end = null): Info
    {
        return Info::new($this, [
    	    Info::PARAM_UID => $uid,
    	    Info::PARAM_SHOW_ENTRIES => $entries,
    	    Info::PARAM_SHOW_SUMMARY => $summary,
    	    Info::PARAM_START => $start,
    	    Info::PARAM_END => $end
    	]);
    }
}
