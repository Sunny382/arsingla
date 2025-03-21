<?php
class PHP_Email_Form {
    public $to = '';
    public $from_name = '';
    public $from_email = '';
    public $subject = '';
    public $ajax = false;
    private $messages = [];

    public function add_message($content, $label = '', $priority = 0) {
        $this->messages[] = ["content" => $content, "label" => $label, "priority" => $priority];
    }

    public function send() {
        $headers = "From: " . $this->from_name . " <" . $this->from_email . ">\r\n";
        $headers .= "Reply-To: " . $this->from_email . "\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $message_body = "";
        foreach ($this->messages as $msg) {
            $message_body .= $msg['label'] . ": " . $msg['content'] . "\n";
        }

        if (mail($this->to, $this->subject, $message_body, $headers)) {
            return "Your message has been sent successfully!";
        } else {
            return "Failed to send email. Please try again.";
        }
    }
}
?>
