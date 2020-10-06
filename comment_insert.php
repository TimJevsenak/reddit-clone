<?php 
    include_once 'database.php';
    include_once 'session.php';
    if(!isset($_SESSION['user_id'])){
        header('location: index.php');
    }

		$version = 0.1;
		function hyperlinks( $text = null )
		{
			if($text == null)
			{
				return false;
			}
			$text = htmlentities($text);
			return preg_replace('/(ftp:\/\/|irc:\/\/|ircs:\/\/|http:\/\/|https:\/\/)([a-zA-Z0-9\/\.\-_:\?,\=]+)/i', '<a href="$1$2">$2</a>', $text);
		}
        function postMarkup( $text = null )
		{
			if( $text == null )
			{
				return false;
			}
			$text = htmlentities($text);
			$text = preg_replace('/\[([a-zA-Z0-9\/\.\-_:\?,\=\s]+)\]\((ftp:\/\/|irc:\/\/|ircs:\/\/|http:\/\/|https:\/\/)([a-zA-Z0-9\/\.\-_:\?,\=]+)\)/i', '<a href="$2$3" target=_new>$1</a>', $text);
			$text = preg_replace('/\*\*([a-zA-Z0-9\/\.\-_:\?,\=\s\)\(\*\&\^\!\@\#\$\%\^\+\=\`\~\{\}\[\]]+)\*\*/i', '<strong>$1</strong>', $text);
			$text = preg_replace('/\-\-([a-zA-Z0-9\/\.\-_:\?,\=\s\)\(\*\&\^\!\@\#\$\%\^\+\=\`\~\{\}\[\]]+)\-\-/i', '<del>$1</del>', $text);
			$text = preg_replace('/\`([a-zA-Z0-9\/\.\-_:\?,\=\s\)\(\*\&\^\!\@\#\$\%\^\+\=\`\~\{\}\[\]]+)\`/i', '<code>$1</code>', $text);
			$text = preg_replace('/\~\~([a-zA-Z0-9\/\.\-_:\?,\=\s\)\(\*\&\^\!\@\#\$\%\^\+\=\`\~\{\}\[\]]+)\~\~/i', '<em>$1<\em>', $text);
			$text = preg_replace('/\_\_([a-zA-Z0-9\/\.\-_:\?,\=\s\)\(\*\&\^\!\@\#\$\%\^\+\=\`\~\{\}\[\]]+)\_\_/i', '<u>$1</u>', $text);
			return $text;
		}

    $id=$_GET['id'];
    $text = postMarkup($_POST['text']);
    if(empty($id) || empty($text)){
        header('location: index.php');
    }

    $query = "INSERT INTO comments (text, post_id, user_id)"
        . "VALUES (?,?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$text, $id, $_SESSION['user_id']]);

        header("location: post_show.php?id=".$id);
?>