<?php declare(strict_types=1);

namespace MyENA\RGW\Chain\Usage;

use MyENA\RGW\AbstractLink;
use MyENA\RGW\Links\ExecutableLink;
use MyENA\RGW\Links\MethodLink;
use MyENA\RGW\Links\ParameterLink;
use MyENA\RGW\Models\UsageInfo;
use MyENA\RGW\Parameter;
use MyENA\RGW\Parameter\SingleParameter;
use MyENA\RGW\Validators;

/**
 * Class Info
 * @package MyENA\RGW\Chain\User
 */
class Info extends AbstractLink implements MethodLink, ParameterLink, ExecutableLink
{
    const METHOD = 'GET';

    const PARAM_UID   = 'uid';
    const PARAM_START   = 'start';
    const PARAM_END   = 'end';
    const PARAM_SHOW_ENTRIES = 'show-entries';
    const PARAM_SHOW_SUMMARY = 'show-summary';
    
    /** @var \MyENA\RGW\Parameter[] */
    private $parameters;

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        return self::METHOD;
    }

    /**
     * @return \MyENA\RGW\Parameter[]
     */
    public function getParameters(): array
    {
        if (!isset($this->parameters)) {
            $this->parameters = [
                (new SingleParameter(self::PARAM_UID, Parameter::IN_QUERY))
                    ->requireValue()
                    ->requireNotEmpty()
                    ->addValidator(Validators::String()),
                (new SingleParameter(self::PARAM_SHOW_ENTRIES, Parameter::IN_QUERY))
                    ->addValidator(Validators::Boolean()),
                (new SingleParameter(self::PARAM_SHOW_SUMMARY, Parameter::IN_QUERY))
                    ->addValidator(Validators::Boolean()),
                (new SingleParameter(self::PARAM_START, Parameter::IN_QUERY))
                    ->addValidator(Validators::DateTime()),
                (new SingleParameter(self::PARAM_END, Parameter::IN_QUERY))
                    ->addValidator(Validators::DateTime()),
            ];
        }
        return $this->parameters;
    }

    /**
     * @return array(
     * @type \MyENA\RGW\Models\UserInfo|null
     * @type \MyENA\RGW\Error|null
     * )
     */
    public function execute(): array
    {
        /** @var \Psr\Http\Message\ResponseInterface $resp */
        /** @var \MyENA\RGW\Error $err */
        [$resp, $err] = $this->client->do($this->buildRequest());
        if (null !== $err) {
            return [null, $err];
        }
        return UsageInfo::fromPSR7Response($resp);
    }
}