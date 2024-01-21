<?php

class tls_icon_with_hmail extends rcube_plugin
{	
	private $message_headers_done = false;
	private $icon_img;

	function init()
	{
		$rcmail = rcmail::get_instance();
		$layout = $rcmail->config->get('layout');

		$this->add_hook('message_headers_output', array($this, 'message_headers'));
		$this->add_hook('storage_init', array($this, 'storage_init'));
		
		$this->include_stylesheet('tls_icon_with_hmail.css');

		$this->add_texts('localization/');
	}
	
	public function storage_init($p)
	{
		$p['fetch_headers'] = trim(($p['fetch_headers']?? '') . ' ' . strtoupper('Received'));
		return $p;
	}
	
	public function message_headers($p)
	{
		if($this->message_headers_done===false)
		{
			$this->message_headers_done = true;

			$Received_Header = $p['headers']->others['received'];
			if(is_array($Received_Header)) {
				$Received = $Received_Header[0];
			} else {
				$Received = $Received_Header;
			}
			
			if($Received == null) {
				// There was no Received Header. Possibly an outbound mail. Do nothing.
				return $p;
			}
			
			if ( preg_match_all('/\(version=TLSv1.2.*\)/im', $Received, $items, PREG_PATTERN_ORDER) ) {
				$data = $items[0][0];

				$needle = "(version=";
				$pos = strpos($data, $needle);
				$data = substr_replace($data, "", $pos, strlen($needle));

				$needle = ")";
				$pos = strrpos($data, $needle);
				$data = substr_replace($data, "", $pos, strlen($needle));
				
				$this->icon_img .= '<img class="lock_icon" src="plugins/tls_icon_with_hmail/lock_tls_12.png" title="'. htmlentities($data) .'" />';
			} else if ( preg_match_all('/\(version=TLSv1.3.*\)/im', $Received, $items, PREG_PATTERN_ORDER) ) {
				$data = $items[0][0];

				$needle = "(version=";
				$pos = strpos($data, $needle);
				$data = substr_replace($data, "", $pos, strlen($needle));

				$needle = ")";
				$pos = strrpos($data, $needle);
				$data = substr_replace($data, "", $pos, strlen($needle));
				
				$this->icon_img .= '<img class="lock_icon" src="plugins/tls_icon_with_hmail/lock_tls_13.png" title="'. htmlentities($data) .'" />';
			} else if(preg_match_all('/\[127.0.0.1\]|\[::1\]/im', $Received, $items, PREG_PATTERN_ORDER)){
				$this->icon_img .= '<img class="lock_icon" src="plugins/tls_icon_with_hmail/blue_lock.png" title="' . $this->gettext('internal') . '" />';
			} 
			else {
				// TODO: Mails received from localhost but without TLS are currently flagged insecure
				//$data = $items[0][0];
				$this->icon_img .= '<img class="lock_icon" src="plugins/tls_icon_with_hmail/unlock.png" title="' . $this->gettext('unencrypted') . '" />';
			}
		}

		if(isset($p['output']['subject']))
		{
			$p['output']['subject']['value'] = htmlentities($p['output']['subject']['value']) . $this->icon_img;
			$p['output']['subject']['html'] = 1;
		}

		return $p;
	}
}
