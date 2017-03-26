<?php

namespace pimax\Messages;


/**
 * Class VideoMessage
 *
 * @package pimax\Messages
 */
class VideoMessage extends Message
{
    /**
     * @var null|string
     */
    protected $recipient = null;

    /**
     * @var null|string
     */
    protected $text = null;

    /**
     * Message constructor.
     *
     * @param string $recipient
     * @param string $file Web Url or local file with @ prefix
     * @param array $quick_replies array of array to be added after attachment
     */
     public function __construct($recipient, $file, $quick_replies = null)
     {
         $this->recipient = $recipient;
         $this->text = $file;
         $this->quick_replies = $quick_replies;
     }

    /**
     * Get message data
     *
     * @return array
     */
    public function getData()
    {
        $res = [
            'recipient' =>  [
                'id' => $this->recipient
            ]
        ];

        $attachment = new Attachment(Attachment::TYPE_VIDEO, [], $this->quick_replies);

        if (strpos($this->text, 'http://') === 0 || strpos($this->text, 'https://') === 0) {
            $attachment->setPayload(array('url' => $this->text));
        } else {
            $attachment->setFileData($this->getCurlValue($this->text, mime_content_type($this->text), basename($this->text)));
        }

        $res['message'] = $attachment->getData();

        return $res;
    }
}
