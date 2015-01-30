<?php
namespace Echosign\RequestBuilders\Widget;

use Echosign\Interfaces\RequestBuilder;
use Echosign\Requests\PostRequest;

class WidgetCreationInfo implements RequestBuilder
{
    const SIGN_ESIGN = 'ESIGN';
    const SIGN_WRITTEN = 'WRITTEN';
    const FLOW_NOT_REQUIRED = 'SENDER_SIGNATURE_NOT_REQUIRED';
    const FLOW_SIGNS_LAST = 'SENDER_SIGNS_LAST';
    const FLOW_SIGNS_FIRST = 'SENDER_SIGNS_FIRST';
    const SEQUENTIAL = 'SEQUENTIAL';
    const PARALLEL = 'PARALLEL';

    protected $widgetCompletionInfo;
    protected $widgetAuthFailureInfo;
    protected $widgetSignerSecurityOptions;
    protected $counterSigners = [];

    /**
     * ['ESIGN' or 'WRITTEN']:
     * @var string
     */
    protected $signatureType = 'ESIGN';
    public $callbackinfo;
    public $locale = 'en_US';

    /**
     * SENDER_SIGNATURE_NOT_REQUIRED, SENDER_SIGNS_LAST, or SENDER_SIGNS_FIRST
     * @var string
     */
    protected  $signatureFlow;
    protected $name;
    protected $formFieldLayerTemplates = [ ];
    protected $securityOptions;
    protected $vaultingInfo;
    protected $mergeFieldInfo = [ ];
    protected $fileInfos = [ ];

    /**
     * @param WidgetFileInfo $fileInfo
     * @param $name
     * @param $signatureFlow
     */
    public function __construct( WidgetFileInfo $fileInfo, $name, $signatureFlow )
    {
        $this->fileInfos[] = $fileInfo;

        $this->setName($name);

        $this->setSignatureFlow($signatureFlow);
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = filter_var($name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        return $this;
    }

    /**
     * for example en_US or fr_FR
     * @param $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        // for example en_US or fr_FR
        $this->locale = $locale;
        return $this;
    }

    /**
     * @param $url
     * @return $this
     */
    public function setCallBackInfo($url)
    {
        $this->callbackinfo = filter_var($url, FILTER_SANITIZE_URL);
        return $this;
    }

    /**
     * @param string $signatureFlow
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setSignatureFlow( $signatureFlow )
    {
        $allowed = ['SENDER_SIGNATURE_NOT_REQUIRED', 'SENDER_SIGNS_LAST',
                    'SENDER_SIGNS_FIRST', 'SEQUENTIAL', 'PARALLEL'];
        if( ! in_array($signatureFlow, $allowed)) {
            throw new \InvalidArgumentException('Invalid signature flow provided. Must be one of: ' . implode(', ', $allowed) );
        }

        $this->signatureFlow = $signatureFlow;

        return $this;
    }

    /**
     * @param WidgetFileInfo $info
     * @return $this
     */
    public function addFormFieldLayerTemplate( WidgetFileInfo $info )
    {
        $this->formFieldLayerTemplates[] = $info;

        return $this;
    }

    /**
     * @param WidgetSecurityOption $option
     * @return $this
     */
    public function addSecurityOption( WidgetSecurityOption $option )
    {
        $this->securityOptions = $option;

        return $this;
    }

    /**
     * @param WidgetMergefieldInfo $info
     * @return $this
     */
    public function addMergeFieldInfo( WidgetMergefieldInfo $info )
    {
        $this->mergeFieldInfo[] = $info;

        return $this;
    }

    /**
     * @param WidgetFileInfo $info
     * @return $this
     */
    public function addFileInfo( WidgetFileInfo $info )
    {
        $this->fileInfos[] = $info;

        return $this;
    }

    /**
     * @return WidgetVaultingInfo
     */
    public function getVaultingInfo()
    {
        return $this->vaultingInfo;
    }

    /**
     * @param WidgetVaultingInfo $vaultingInfo
     */
    public function setVaultingInfo( WidgetVaultingInfo $vaultingInfo )
    {
        $this->vaultingInfo = $vaultingInfo;
    }

    /**
     * @return CounterSignerInfo[]
     */
    public function getCounterSigners()
    {
        return $this->counterSigners;
    }

    /**
     * @param CounterSignerInfo[]
     */
    public function setCounterSigners( $counterSigners )
    {
        $this->counterSigners = $counterSigners;
    }

    /**
     * @param CounterSignerInfo $counterSignerInfo
     */
    public function addCounterSigner( CounterSignerInfo $counterSignerInfo )
    {
        $this->counterSigners[] = $counterSignerInfo;
    }

    /**
     * @return WidgetCompletionInfo
     */
    public function getWidgetCompletionInfo()
    {
        return $this->widgetCompletionInfo;
    }

    /**
     * @param WidgetCompletionInfo $widgetCompletionInfo
     */
    public function setWidgetCompletionInfo( WidgetCompletionInfo $widgetCompletionInfo )
    {
        $this->widgetCompletionInfo = $widgetCompletionInfo;
    }

    /**
     * @return WidgetCompletionInfo
     */
    public function getWidgetAuthFailureInfo()
    {
        return $this->widgetAuthFailureInfo;
    }

    /**
     * @param WidgetCompletionInfo $widgetAuthFailureInfo
     */
    public function setWidgetAuthFailureInfo( WidgetCompletionInfo $widgetAuthFailureInfo )
    {
        $this->widgetAuthFailureInfo = $widgetAuthFailureInfo;
    }

    /**
     * @return WidgetSignerSecurityOption
     */
    public function getWidgetSignerSecurityOptions()
    {
        return $this->widgetSignerSecurityOptions;
    }

    /**
     * @param WidgetSignerSecurityOption $widgetSignerSecurityOptions
     */
    public function setWidgetSignerSecurityOptions( $widgetSignerSecurityOptions )
    {
        $this->widgetSignerSecurityOptions = $widgetSignerSecurityOptions;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'signatureType'            => $this->signatureType,
            'callbackInfo'             => $this->callbackinfo,
            'locale'                   => $this->locale,
            'signatureFlow'            => $this->signatureFlow,
            'name'                     => $this->name,
            'widgetCompletionInfo'     => $this->widgetCompletionInfo->toArray(),
            'widgetAuthFailureInfo'    => $this->widgetAuthFailureInfo->toArray(),
            'widgetSignerSecurityOptions' => $this->widgetSignerSecurityOptions->toArray(),
        ];

        if( count( $this->formFieldLayerTemplates ) ) {
            $data['formFieldLayerTemplates'] = [];
            foreach( $this->formFieldLayerTemplates as $t ) {
                $data['formFieldLayerTemplates'][] = $t->toArray();
            }
        }

        if( count( $this->fileInfos ) ) {
            $data['fileInfos'] = [];
            foreach( $this->fileInfos as $t ) {
                $data['fileInfos'][] = $t->toArray();
            }
        }

        if( count( $this->mergeFieldInfo ) ) {
            $data['mergeFieldInfo'] = [];
            foreach( $this->mergeFieldInfo as $t ) {
                $data['mergeFieldInfo'][] = $t->toArray();
            }
        }

        if( count( $this->counterSigners ) ) {
            $data['counterSigners'] = [];
            foreach( $this->counterSigners as $t ) {
                $data['counterSigners'][] = $t->toArray();
            }
        }

        if( $this->securityOptions ) {
            $data['securityOptions'] = $this->securityOptions->toArray();
        }

        if( $this->vaultingInfo ) {
            $data['vaultingInfo'] = $this->vaultingInfo->toArray();
        }

        return array_filter( $data );
    }

}