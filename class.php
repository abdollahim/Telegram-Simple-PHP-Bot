<?php

require_once("database.php");

class SampleBotClass
{
    private $botToken;
	private $botServer;
	private $botFileServer;
	
	private $currentDirectory;
	
	// main message attributes
	private $messageId;
	
	// message from part
	private $chatId;
	private $isBot;
	private $firstName;
	private $lastName;
	private $userName;
	private $languageCode;
	
	// message chat part
	private $chatType;
	private $text;
	private $entityLength;
	
	private $messageType;
	private $requestType;
	
	// voice message attributes
	private $voiceDuration;
	private $voiceMimeType;
	private $voiceFileId;
	private $voiceFileSize;
	
	// document message attributes
	private $documentFileName;
	private $documentMimeType;
	private $documentFileId;
	private $documentFileSize;
	
	// phone message attributes
	private $phoneNumber;
	
	// PDO database connection
	private $databaseObject;
  
	public function __construct()
	{ 			
		$this->botToken = "XXXXXXXXX:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
		$this->botServer = "https://api.telegram.org/bot".$this->botToken;
		$this->botFileServer = "https://api.telegram.org/file/bot".$this->botToken;
		
		
		// base file directory
		$this->currentDirectory = "files/";
		
		// initialize main message attributes
		$this->messageId = null;
		
		// initialize from message attributes
		$this->chatId = null;
		$this->isBot = null;
		$this->firstName = null;
		$this->lastName = null;
		$this->userName = null;
		$this->languageCode = null;
		
		// initialize chat message attributes
		$this->chatType = null;
		$this->text = null;
		$this->entityLength = null;
		
		$this->messageType = null;
		$this->requestType = 0;
		
		// initiallize voice message attributes
		$this->voiceDuration = null;
		$this->voiceMimeType = null;
		$this->voiceFileId = null;
		$this->voiceFileSize = null;
		
		// initiallize document message attributes
		$this->documentFileName = null;
		$this->documentMimeType = null;
		$this->documentFileId = null;
		$this->documentFileSize = null;
		
		// initiallize phone message attributes
		$this->phoneNumber = null;
		
		// initiallize database
		$this->databaseObject = new DB();
	}
	
	public function FillValues($data)
	{
		$this->messageId = $data["message"]["message_id"];
		
		// fill text message attributes
		if(isset($data["message"]["from"]))
		{
			$this->chatId = $data["message"]["from"]["id"];
			$this->isBot = $data["message"]["from"]["is_bot"];
			
			if(isset($data["message"]["from"]["first_name"]))
			{
				$this->firstName = $data["message"]["from"]["first_name"];
			}
			
			if(isset($data["message"]["from"]["last_name"]))
			{
				$this->lastName = $data["message"]["from"]["last_name"];
			}
			
			if(isset($data["message"]["from"]["username"]))
			{
				$this->userName = $data["message"]["from"]["username"];
			}
			
			if(isset($data["message"]["from"]["language_code"]))
			{
				$this->languageCode = $data["message"]["from"]["language_code"];
			}
		}
		
		// fill chat message attributes
		if($data["message"]["chat"])
		{
			$this->chatType = $data["message"]["chat"]["type"];
		}
		
		// fill text message attributes
		if(isset($data["message"]["text"]))
		{
			$this->messageType = "text";
			$this->text = $data["message"]["text"];
		}

		// fill entity message attributes
		if(isset($data["message"]["entities"]))
		{
			$this->messageType = "entity";
			if(isset($data["message"]["entities"][0]["length"]))
			{
				$this->entityLength = $data["message"]["entities"][0]["length"];
			}
		}
		
		// fill voice message attributes
		if(isset($data["message"]["voice"]))
		{
			$this->messageType = "voice";
			$this->voiceDuration = $data["message"]["voice"]["duration"];
			$this->voiceMimeType = $data["message"]["voice"]["mime_type"];
			$this->voiceFileId = $data["message"]["voice"]["file_id"];
			$this->voiceFileSize = $data["message"]["voice"]["file_size"];
		}
		
		// fill document message attributes
		if(isset($data["message"]["document"]))
		{
			$this->messageType = "document";
			$this->documentFileName = $data["message"]["document"]["file_name"];
			$this->documentMimeType = $data["message"]["document"]["mime_type"];
			$this->documentFileId = $data["message"]["document"]["file_id"];
			$this->documentFileSize = $data["message"]["document"]["file_size"];
		}
		
		// fill photo message attributes
		if(isset($data["message"]["photo"]))
		{
			$this->messageType = "photo";
		}
		
		// fill contact message attributes
		if(isset($data["message"]["contact"]))
		{
			$this->messageType = "contact";
			$this->phoneNumber = $data["message"]["contact"]["phone_number"];
		}
		
		return true;
	}
	
	public function SetRequestType($type)
	{
		$this->requestType = $type;
	}
	
	public function SetKeyboard($replyMarkup, $text)
	{
		file_get_contents($this->botServer."/sendmessage?chat_id=".$this->chatId."&reply_markup=".json_encode($replyMarkup)."&parse_mode=Markdown&text=".$text);
	}
	
	public function GetChatId()
	{
		return $this->chatId;
	}
	
	public function GetUsername()
	{
		return $this->userName;
	}
	
	public function GetMessageText()
	{
		return $this->text;
	}
	
	// get voice properties
	public function GetVoiceDuration()
	{
		return $this->voiceDuration;
	}
	
	public function GetVoiceMimeType()
	{
		return $this->voiceMimeType;
	}
	
	public function GetVoiceFileId()
	{
		return $this->voiceFileId;
	}
	
	public function GetVoiceFileSize()
	{
		return $this->voiceFileSize;
	}
	
	// get document properties
	public function GetDocumentFileName()
	{
		return $this->documentFileName;
	}
	
	public function GetDocumentMimeType()
	{
		return $this->documentMimeType;
	}
	
	public function GetDocumentFileId()
	{
		return $this->documentFileId;
	}
	
	public function GetDocumentFileSize()
	{
		return $this->documentFileSize;
	}
	
	// get phone number properties
	public function GetPhoneNumber()
	{
		return $this->phoneNumber;
	}
	
	public function GetMessageType()
	{
		return $this->messageType;
	}
	
	// general functions
	
    public function SendMessage($message)
	{
		file_get_contents($this->botServer."/sendmessage?chat_id=".$this->chatId."&text=".urlencode($message));
	}
	
	public function GetFilePath($fileId)
	{
		$file_result = file_get_contents($this->botServer."/getFile?file_id=".$fileId);
		$file_array = json_decode($file_result, TRUE);
		
		if($file_array["ok"] == true)
			return $file_array["result"]["file_path"];
		else
			return false;
	}
	
	public function DownloadFile($telegramFilePath, $localDirectoryPath, $localFilePath)
	{	
		// create directory
		if (!file_exists($localDirectoryPath))
		{
			mkdir($localDirectoryPath, 0755, true);
		}
		
		$filePointer = @fopen($localDirectoryPath.$localFilePath, 'w');
		if($filePointer == false)
		{
			return false;
		}
		else
		{
			$curlRequest = curl_init($this->botFileServer.'/'.$telegramFilePath);
			if($curlRequest == false)
			{
				return false;
			}
			else
			{
				if(curl_setopt($curlRequest, CURLOPT_FILE, $filePointer) == false)
				{
					return false;
				}
				else
				{
					if(curl_exec($curlRequest) == false)
					{
						return false;
					}
					else
					{
						curl_close($curlRequest);
						fclose($filePointer);
						return true;
					}
				}
			}
		}
	}
	
	public function SendPhotoFromURL($user, $url, $pageUsername, $pageLink)
	{
		file_get_contents($this->botServer."/sendphoto?chat_id=".$this->chatId."&photo=".urlencode($url)."&caption=".$user."&reply_to_message_id=".$this->messageId);
		$this->databaseObject->AddLog($url . '-' . $pageUsername . '-' . $pageLink);
	}
	
	public function SendVideoFromURL($user, $url, $pageUsername, $pageLink)
	{
		file_get_contents($this->botServer."/sendvideo?chat_id=".$this->chatId."&video=".urlencode($url)."&caption=".$user."&reply_to_message_id=".$this->messageId);
		$this->databaseObject->AddLog($url . '-' . $pageUsername . '-' . $pageLink);
	}
	
	// maybe you want to send some log messages to the admin chat, groups, or channels.
	private function AdminLog($adminMessage)
	{
		file_get_contents($this->botServer."/sendmessage?chat_id=@XXXXXXXXXXX&text=".urlencode($adminMessage));
	}
}

?>