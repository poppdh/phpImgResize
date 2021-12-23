# php 이미지 리사이즈

```
require_once 'imgresize.php';
// 연결

// 함수실행
$imgStatus = resizeImg('img/agif.gif', 'img/new33', 500, 0);
if($imgStatus === true){
  echo '저장 성공';
}else{
  echo '저장 실패';
}

```
