<?
	/*
	* Arguments
	* 1 : 파일명
	* 2 : 새이름으로 저장될 경로/파일명(확장자제외)
	* 3 : 가로사이즈(세로기준으로 비율을 맞추려면 0)
	* 4 : 세로사이즈(가로기준이면 비율을 맞추려면 0)
	*	가로, 세로값 있을 경우 강제 리사이즈
	* 둘중 한 값만 있을 경우 비율에 맞춰서 리사이즈
	*/

	function calcSize($maxw, $width, $maxh, $height){
		if($maxw !== 0 && $maxh !== 0){
			$retdata = [
				"w" => $maxw < $width ? $maxw : $width,
				"h" => $maxh < $height ? $maxh : $height,
			];
		}else if($maxw !== 0 && $maxh === 0){
			$per = $maxw / $width * 100;
			$retdata = [
				"w" => $maxw < $width ? $maxw : $width,
				"h" => $maxw < $width ? intval($height / 100 * $per) : $height,
			];
		}else if($maxw === 0 && $maxh !== 0){
			$per = $maxh / $height * 100;
			$retdata = [
				"w" => $maxh < $height ? intval($width / 100 * $per) : $width,
				"h" => $maxh < $height ? $maxh : $height,
			];
		}
		return $retdata;
	}

	function resizeImg($fileName, $fileRename, $maxw, $maxh){
		$ext = strtolower(substr(strrchr($fileName, '.'), 1));
		list($width, $height) = getimagesize($fileName, $info);
		if($width !== null && $height !== null){
			$size = calcSize($maxw, $width, $maxh, $height);
			$image_p = imagecreatetruecolor($size['w'], $size['h']);
		
			if($ext === 'jpg' || $ext === 'jpeg'){
				$image = imagecreatefromjpeg($fileName);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $size['w'], $size['h'], $width, $height);
				imagejpeg($image_p, $fileRename.'.'.$ext, 100);
				return true;
			}else if($ext === 'png'){
				$background = imagecolorallocate($image_p , 0, 0, 0);
				imagecolortransparent($image_p, $background);
				imagealphablending($image_p, false);
				imagesavealpha($image_p, true);
				$image = imagecreatefrompng($fileName);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $size['w'], $size['h'], $width, $height);
				imagepng($image_p, $fileRename.'.'.$ext, 9);
				return true;
			}else if($ext === 'gif'){
				$image = imagecreatefromgif($fileName);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $size['w'], $size['h'], $width, $height);
				imagegif($image_p, $fileRename.'.'.$ext);
				return true;
			}
		}else{
			return false;
		}
	}
?>
