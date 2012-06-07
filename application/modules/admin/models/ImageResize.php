<?php

/* 
Developer Note:
ini_set('memory_limit', '-1'); is used because some images exceed the allowed memory limit.
*/
ini_set('memory_limit', '-1');
class Admin_Model_ImageResize
{
 
	private $image;
	private $width;
	private $height;
	private $imageResized;
 
	public function __construct($filename) {
		$this->image = $this->openImage($filename);
		$this->width  = imagesx($this->image);
		$this->height = imagesy($this->image);
   	}
   
	private function openImage($file)
	{
		$extension = strtolower(strrchr($file, '.'));

		switch($extension)
		{
			case '.jpg':
			case '.jpeg':
				$img = imagecreatefromjpeg($file);
				break;
			case '.gif':
				$img = imagecreatefromgif($file);
				break;
			case '.png':
				$img = imagecreatefrompng($file);
				break;
			default:
				$img = false;
				break;
		}
		return $img;
	}
	
	public function resizeImage($newWidth, $newHeight, $option='exact')
	{
		$optionArray = $this->getDimensions($newWidth, $newHeight, $option);

		$optimalWidth  = $optionArray['optimalWidth'];
		$optimalHeight = $optionArray['optimalHeight'];


		$this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
		if (imagetypes() & IMG_PNG) {
			imagesavealpha($this->imageResized, true);
			imagealphablending($this->imageResized, false);
		}
		imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);
	}
	
	private function getDimensions($newWidth, $newHeight, $option)
	{
		switch ($option)
		{
			case 'exact':
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
				break;
			case 'portrait':
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
				break;
			case 'landscape':
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
				break;
			case 'auto':
				$optionArray = $this->getSizeByAuto($newWidth, $newHeight);
				$optimalWidth = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];
				break;
		}
		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}
	
	private function getSizeByFixedHeight($newHeight)
	{
		$ratio = $this->width / $this->height;
		$newWidth = $newHeight * $ratio;
		return $newWidth;
	}

	private function getSizeByFixedWidth($newWidth)
	{
		$ratio = $this->height / $this->width;
		$newHeight = $newWidth * $ratio;
		return $newHeight;
	}

	private function getSizeByAuto($newWidth, $newHeight)
	{
		if ($this->height < $this->width) {
			$optimalWidth = $newWidth;
			$optimalHeight= $this->getSizeByFixedWidth($newWidth);
		} elseif ($this->height > $this->width) {
			$optimalWidth = $this->getSizeByFixedHeight($newHeight);
			$optimalHeight= $newHeight;
		} else {
			if ($newHeight < $newWidth) {
				$optimalWidth = $newWidth;
				$optimalHeight= $this->getSizeByFixedWidth($newWidth);
			} else if ($newHeight > $newWidth) {
				$optimalWidth = $this->getSizeByFixedHeight($newHeight);
				$optimalHeight= $newHeight;
			} else {
				$optimalWidth = $newWidth;
				$optimalHeight= $newHeight;
			}
		}

		return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
	}
	
	public function saveImage($savePath, $imageQuality="100")
	{
		$extension = strrchr($savePath, '.');
        $extension = strtolower($extension);

		switch($extension)
		{
			case '.jpg':
			case '.jpeg':
				if (imagetypes() & IMG_JPG) {
					imagejpeg($this->imageResized, $savePath, $imageQuality);
				}
				break;

			case '.gif':
				if (imagetypes() & IMG_GIF) {
						imagegif($this->imageResized, $savePath);
				}
				break;

			case '.png':
				$scaleQuality = round(($imageQuality/100) * 9);

				$invertScaleQuality = 9 - $scaleQuality;

				if (imagetypes() & IMG_PNG) {
					imagepng($this->imageResized, $savePath, $invertScaleQuality);
				}
				break;
			default:
				break;
		}

		imagedestroy($this->imageResized);
	}  
}

