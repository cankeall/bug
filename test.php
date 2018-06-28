<?php
$str = "A 'quote' is <b>bold</b>";

// 输出: A 'quote' is &lt;b&gt;bold&lt;/b&gt;
echo htmlentities($str);

// 输出: A &#039;quote&#039; is &lt;b&gt;bold&lt;/b&gt;
echo htmlspecialchars($str, ENT_QUOTES);

$bb = "<a href='test'>Test</a>";
$new = htmlspecialchars($bb, ENT_QUOTES);
echo $new; // &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<p><?php echo $bb; ?></p>
<p><?php echo $new; ?></p>
<p><?php echo htmlspecialchars($bb, ENT_QUOTES); ?></p>
</body>
</html>