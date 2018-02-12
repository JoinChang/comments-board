<!DOCTYPE html>
<html lang="zh-cmn-Hans">
<head>
<title>留言板</title>
<!--[if lt IE 8]><script>alert('不支持 IE 9 （不含）以下的浏览器');</script><![endif]-->
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="theme-color" content="#0078D7" />
<link rel="shortcut icon" type="image/ico" href="favicon.ico" />
<script src="jquery.min.js"></script> 
<script>
	$(function() {
		var comments = $("#comments"); 
		var newcomments = $("#new-comments") 
		$.getJSON("data.php", function(json) {
			$.each(json, function(index, array) {
				var txt = "<div class='comments-body'><h3 class='comments-user'><strong>" + array["user"] + "</strong></h3><p class='comments-time'>" + array["addtime"] + "</p><hr><p class='comments-text'>" + array["comment"] + "</p></div>";
				comments.append(txt);
			});
		});
		$('.btn').click(function(){
			$.post(
				'recaptcha.php',
				{'yzm':$('#yzm').val()},
				function(data){
					if (data == 0) {
						var user = $("#user").val();
						var txt = $("#txt").val();
						$.ajax({
							type: "POST",
							url: "comment.php",
							data: "user=" + user + "&txt=" + txt + "&ip=true",
							dataType : 'JSON',
							success: function(res) {
								if (res.code == 1) {
									var str = "<div class='comments-body'><h3 class='comments-user'><strong>" + res.user + "</strong></h3><p class='comments-time'>刚刚</p>" + "<hr><p class='comments-text'>" + res.txt + "</p></div>";
									newcomments.append(str);
									$("#message").show().html("<div class='success'>发表成功<br>昵称: " + res.user + "<br>内容: " + res.txt + "</div>").fadeOut(5000);
									$("#txt").attr("value", "");
									commenttxt = res.txt;
								} else {
									$("#message").show().html("<div class='fail'>" + res.message + "</div>").fadeOut(5000);
								}
							}
						});
						huan();
					} else {
						$("#message").show().html("<div class='fail'>验证码输入错误</div>").fadeOut(5000); 
						huan();
					}
				}
 			)
		})	
	});

	$(document).ready(function(){
		var lenInput = $('.input').val().length;
		var lenInput2 = $('.input-user').val().length;
		$(".input").keyup(function(){
			lenInput = $(this).val().length;
			$('.input-length').html(lenInput);
			if (lenInput>0 && lenInput<=300) {
				$('.input-length').css("color","gray");
				$('.btn').attr('disabled',false);
			} else {
				$('.input-length').css("color","red");
				$('.btn').attr('disabled',true);
			}
		});
		$(".input-user").keyup(function(){
			lenInput2 = $(this).val().length;
			$('.input-user-length').html(lenInput2);
			if (lenInput2>0 && lenInput2<=25) {
				$('.input-user-length').css("color","gray");
				$('.btn').attr('disabled',false);
			} else {
				$('.input-user-length').css("color","red");
				$('.btn').attr('disabled',true);
			}
		});
	});

	function huan() {
		var num = Math.random() * 10;
		document.getElementById('yzimg').src='code.php?r='+num;
	}
</script>
<style>
	/* 滚动条开始 */   
	/* webkit 支持 */
	::-webkit-scrollbar { 
		width: 9px;
	}
    ::-webkit-scrollbar-button { 
		height: 0;
	}
    ::-webkit-scrollbar-track { 
		background: white;
	}
    ::-webkit-scrollbar-track-piece { 
		border-left: 1px solid #c1c1c1; 
	}
    ::-webkit-scrollbar-thumb { 
		background: #c1c1c1;
	}
    ::-webkit-scrollbar-thumb:hover { 
		background: #a9a9a9;
	}
	/* 滚动条结束 */
	* {
		font-family: 等线;
		word-wrap: break-word; 
		/* 手机端点击去除蓝色底色 */
		-webkit-tap-highlight-color: transparent;
	}
	::selection {
		background: #99CCFF;
	}
	a {
		color: dimgray;
		font-weight: bold;
		text-decoration: none;
		transition: all .3s;
	}
	a:hover {
		text-decoration: underline;
	}
	body {
		overflow-y: hidden;
		background: #f5f5f5;
	}
	body>div {
		position: fixed;
		overflow-y: scroll !important;
		height: calc(100vh - 50px);
		margin-left: -8px;
		bottom: 0;
		width: 100%;
	}
	header {
		position: relative;
		z-index: 999;
		margin: -8px;
		height: 50px;
		box-shadow: 0 5px 15px rgba(0,0,0,.3);
		user-select: none;
		background: white;
	}
	header>img {
		margin: 10px;
		height: 30px;
		cursor: pointer;
		position: fixed;
		z-index: 1000;
	}
	header>p {
		position: fixed;
		top: 0;
		color: dimgray;
	}
	.name {
		font-size: 20px; 
		font-weight: bold;
		margin: 0 5px 0 55px;
		cursor: pointer;
	}
	@media (max-width: 224px) {
		.version {
			display: none;
		}
	}
	h1,h2,h3,h4,h5,h6 {
		margin: 0;
		color: dimgray;
	}
	ul {
		list-style: none;
		counter-reset: count;
		margin-left: -15px;
		margin: 5px 5px 5px -30px;
	}
	li {
		color: gray;
	}
	li:before {
		content: "• ";
		color: dimgray;
	}
	mask {
		background: dimgray;
	}
	mask::selection {
		background: white;
	}
	hr {
		height: 1px;
		border: none;
		border-top: 1px solid lightgray;
	}
	/* 整体宽度适配 */
	@media (min-width: 1000px) {
		#post,#check,#author,#copy,#domainlist {
			width: 930px;
			margin-left: auto !important;
			margin-right: auto !important;
		}
		#new-comments,#comments {
			width: 990px;
			margin-left: auto;
			margin-right: auto;
		}
	}
	#post {
		padding: 15px;
		box-shadow: 0 0 15px rgba(0,0,0,.5);
		margin:15px;
		background: white;
		border-radius: 4px;
		transition: box-shadow .3s;
	}
	#post:hover {
		box-shadow: 0 0 15px rgba(0,0,0,.7);
	}
	#post>h3 {
		color: dimgray;
		margin: 0;
		display: inline;
	}
	#post>p {
		color: gray;
		margin: 0;
	}
	#check {
		padding: 15px;
		box-shadow: 0 0 15px rgba(0,0,0,.5);
		margin:15px;
		color: gray;
		background: white;
		border-radius: 4px;
		transition: box-shadow .3s;
	}
	#check:hover {
		box-shadow: 0 0 15px rgba(0,0,0,.7);
	}
	.comments-body {
		padding: 15px;
		box-shadow: 0 0 15px rgba(0,0,0,.5);
		margin: 15px;
		color: dimgray;
		background: white;
		border-left: 5px solid #0078D7;
		border-radius: 4px;
		transition: box-shadow .3s;
	}
	.comments-body:hover {
		box-shadow: 0 0 15px rgba(0,0,0,.7);
	}
	.comments-body>p {
		display:none;
	}
	.comments-user {
		display: inline;
		color: dimgray;
	}
	.comments-time {
		display: inline !important;
		color: gray;
		margin-left: 15px;
	}
	.comments-text {
		margin: 0;
		color: dimgray;
		display: block !important;
	}
	/* 防止文本框超框 */
	@media (max-width: 205px) {
		.input-user,
		.input-recaptcha {
			width: calc(100% - 5px);
		}
	}
	@media (max-width: 172px) {
		#yzimg {
			height: auto;
			width: calc(100% - 3px);
		}
	}
	.btn {
		border: none;
		box-shadow: 0 0 15px rgba(0,0,0,.5);
		width: 100%;
		height: 50px;
		line-height: 18px;
		font-size: 16px;
		background: #0078D7;
		color: #FFF;
		padding-bottom: 4px;
		cursor: pointer;
		transition: all .3s;
	} 
	.btn:hover {
		opacity: .8;
	}
	.btn:active {
		opacity: .6;
	}
	.btn:disabled {
		opacity: .5;
		cursor: not-allowed;
	}
	.btn:disabled:hover {
		opacity: .5;
	}
	input {
		border: 1px solid #a9a9a9;
	}
	.input {
		resize: none;
		height: 80px;
		overflow-x: hidden;
		width: calc(100% - 5px);
		caret-color: dimgray;
		border: 1px solid #a9a9a9;
	}
	.input-user,
	.input-recaptcha {
		caret-color: dimgray;
		border: 1px solid #a9a9a9;
		padding: 2px;
	}
	.input:focus,
	.input-user:focus,
	.input-recaptcha:focus {
		outline: none;
	}
	.input-length,
	.input-user-length {
		color: red;
	}
	#yzimg {
		border: 1px solid #a9a9a9;
		cursor: pointer;
	}
	.success {
		position: fixed;
		z-index: 999;
		top: 65px;
		color: green;
		border-left: 5px solid green;
		background: #66CC66;
		padding: 15px;
		box-shadow: 0 0 15px rgba(0,0,0,.5);
		transition: all 0.3s;
		left: 15px;
		border-radius: 4px;
	}
	.fail {
		position: fixed;
		z-index: 999;
		top: 65px;
		color: red;
		border-left: 5px solid red;
		background: #FF9999;
		padding: 15px;
		box-shadow: 0 0 15px rgba(0,0,0,.5);
		transition: all 0.3s;
		left: 15px;
		border-radius: 4px;
	}
	#about {
		display: none;
	}
	#author,#copy,#domainlist {
		padding: 15px;
		box-shadow: 0 0 15px rgba(0,0,0,.5);
		margin:15px;
		background: white;
		border-radius: 4px;
		transition: box-shadow .3s;
	}
	#author:hover,
	#copy:hover,
	#domainlist:hover {
		box-shadow: 0 0 15px rgba(0,0,0,.7);
	}
	#author>img {
		height: 100px;
		box-shadow: 0 0 15px rgba(0,0,0,.5);
		border-radius: 50px;
		transition: box-shadow .3s;
	}
	#author>img:hover {
		box-shadow: 0 0 15px rgba(0,0,0,.7);
	}
	#author {
		text-align: center;
		font-weight: bold;
		color: dimgray;
	}
	#author>p {
		margin: 15px 0 0 0;
	}
	#copy>p {
		margin: 0;
		text-align: center;
		color: dimgray;
	}
	#domainlist>p {
		margin: 0;
		color: dimgray;
	}
	.expression {
		margin: 0 0 -5px 0;
	}
	.refresh {
		position: relative;
		float: right;
		cursor: pointer;
		top: -15px;
		right: -15px;
		padding: 15px;
		border-radius: 0 4px 0 4px;
		transition: all .3s;
		user-select: none;
	}
	.refresh:hover {
		color: white !important;
		background: rgba(255,0,0,.7);
	}
	.refresh:active {
		color: white !important;
		background: rgba(255,0,0,.5);
	}
	/* 夜间模式样式
	body,#post,.comments-body,header,#author,#copy,input,textarea {
		background: dimgray !important;
	}
	p,h1,h2,h3,h4,h5,h6,li,li:before,a,.comments-body,span {
		color: white !important;
	}
	*/
</style>
</head> 
<body>
<header>
	<img src="lxnet.png" onclick="window.location.href='https://lxns.ml/'" alt="Lxnet" title="主页" ondragstart="return false;">
	<p><span class="name" onclick="about()" onmousemove="this.innerHTML='关于页'" onmouseleave="this.innerHTML='留言板'">留言板</span><span class="version">Pre-Alpha 1.7</span></p>
</header>
<div id="main">
	<div id="post">
		<p onclick="refresh()" class="refresh" title="若遇到部分样式未生效，点击此处以重新运行解析器">刷新</p>
		<p><strong>昵称</strong> <span class="input-user-length">0</span>/25
		<br><input type="text" class="input-user" id="user" onkeyup="value=value.replace(/[^A-Za-z0-9_\-\u4e00-\u9fa5 ]+/ig,'')" /></p>
		<br>
		<p><strong>评论内容</strong> <span class="input-length">0</span>/300
		<br><textarea class="input" id="txt"></textarea></p>
		<br>
		<p><strong>文本样式语法</strong></p>
		<ul class="grammar-ul">
			<li>[h1]一级标题[/h1]</li>
			<li>……</li>
			<li>[h6]六级标题[/h6]</li>
			<li>[br]换行</li>
			<li>[b]粗体[/b]</li>
			<li>[i]斜体[/i]</li>
			<li>[u]下划线[/u]</li>
			<li>[s]删除线[/s]</li>
			<li>[mask]马赛克[/mask]</li>
			<li>[ex-1] <img src="expression/ex-1.png" class="expression" style="margin-top: 5px;"></li>
			<li>[ex-2] <img src="expression/ex-2.png" class="expression" style="margin-top: 5px;"></li>
			<li>[ex-3] <img src="expression/ex-3.png" class="expression" style="margin-top: 5px;"></li>
		</ul>
		<p>* 当链接套在标题内时标题将会失效，请勿<strong>恶意</strong>使用标题</p>
		<br>
		<p><strong>验证码</strong>
		<br><img src="code.php" width="100" height="40" id="yzimg" title="点击更换验证码" onclick="huan()" alt="recaptcha">
		<br><input type="text" class="input-recaptcha" id="yzm" onkeyup="value=value.replace(/[^0-9]+/ig,'')" /></p>
		<div id="message"></div>
		<br>
		<p><input type="submit" class="btn" value="发表" id="add" onclick="this.disabled=true" disabled></p>
	</div>
	<div id="check"><img src="loading.svg" style="margin:-15px 5px -15px -5px">浏览器安全检查</div>
	<div id="new-comments"></div>
	<div id="comments" style="display:none;"></div>
</div>
<div id="about">
	<div id="author">
		<img src="author.png" alt="author">
		<p>Lxns</p>
		<p><a href="update.txt">更新日志</a></p>
	</div>
	<div id="domainlist">
  	<p><b>留言板域名列表</b></p>
    <ul>
        <li><a href="https://lxns.ml/comments">https://lxns.ml/comments</a></li>
        <li><a href="http://nazo.ml">http://nazo.ml/</a></li>
    </ul>
    <p>以上为所有可用留言板域名</p>
    </div>
	<div id="copy">
		<p>本作品采用<a href="https://creativecommons.org/licenses/by-nc-sa/4.0/">BY-NC-SA</a>，即署名、非商业用途、相同方式共享进行许可</p>
		<br>
		<p>Copyright © 2018 <a href="https://lxns.ml/about">Lxnet</a>. All rights reserved.</p>
	</div>
</div>
<script>
	var localhost = window.location.host;
	function about() {
		$('#main').slideUp("slow");
		$('#about').slideDown("slow");
		$('.name').attr("onmousemove","this.innerHTML='主页面'");
		$('.name').attr("onclick","main()");
		if (localhost == 'lxns.ml'){
			window.history.pushState({},0,'https://' + localhost + '/comments/#about');
		} else {
			window.history.pushState({},0,'http://' + localhost + '/#about');
		}
	}
	function main() {
		$('#main').slideDown("slow");
		$('#about').slideUp("slow");
		$('.name').attr("onmousemove","this.innerHTML='关于页'");
		$('.name').attr("onclick","about()");
		if (localhost == 'lxns.ml'){
			window.history.pushState({},0,'https://' + localhost + '/comments/');
		} else {
			window.history.pushState({},0,'http://' + localhost + '/');
		}
	}
	window.onload = function() {
		refresh();
	}
	// 解析器
	function refresh() {
		var a = $("#comments")[0];
		var objTimer = window.setInterval(function(){
			a.innerHTML = a.innerHTML.replace(/\[br\]([^<>]*)/gi, '<br />$1'); // 换行
		},100);
		window.setTimeout(function(){
			a.innerHTML = a.innerHTML.replace(/\[h1\]([^<>]*)\[\/h1\]/gi, '<h1>$1</h1>'); // 一级标题
			a.innerHTML = a.innerHTML.replace(/\[h2\]([^<>]*)\[\/h2\]/gi, '<h2>$1</h2>'); // 二级标题
			a.innerHTML = a.innerHTML.replace(/\[h3\]([^<>]*)\[\/h3\]/gi, '<h3>$1</h3>'); // 三级标题
			a.innerHTML = a.innerHTML.replace(/\[h4\]([^<>]*)\[\/h4\]/gi, '<h4>$1</h4>'); // 四级标题
			a.innerHTML = a.innerHTML.replace(/\[h5\]([^<>]*)\[\/h5\]/gi, '<h5>$1</h5>'); // 五级标题
			a.innerHTML = a.innerHTML.replace(/\[h6\]([^<>]*)\[\/h6\]/gi, '<h6>$1</h6>'); // 六级标题
			a.innerHTML = a.innerHTML.replace(/\[b\]([^<>]*)\[\/b\]/gi, '<b>$1</b>'); // 粗体
			a.innerHTML = a.innerHTML.replace(/\[i\]([^<>]*)\[\/i\]/gi, '<i>$1</i>'); // 斜体
			a.innerHTML = a.innerHTML.replace(/\[u\]([^<>]*)\[\/u\]/gi, '<u>$1</u>'); // 下划线
			a.innerHTML = a.innerHTML.replace(/\[s\]([^<>]*)\[\/s\]/gi, '<s>$1</s>'); // 删除线
			a.innerHTML = a.innerHTML.replace(/\[mask\]([^<>]*)\[\/mask\]/gi, '<mask>$1</mask>'); // 马赛克
			a.innerHTML = a.innerHTML.replace(/\[ex-([^<>]*?)\]/gi, '<img src="expression/ex-$1.png" class="expression" alt="表情">'); // 表情
		},1500);
		window.setTimeout(function(){
			window.clearInterval(objTimer);
			$("#check").fadeOut(500);
			window.setTimeout(function(){
				$("#comments").fadeIn(500);
			},500)
		},3000);
	};
	window.setTimeout(function(){
		var re = new RegExp("((?:http|https|ftp|mms|rtsp)://(&(?=amp;)|[A-Za-z0-9\./=\?%_~@&#:;!*$\+\-])+)", "gi");
		$("#comments")[0].innerHTML = $("#comments")[0].innerHTML.replace(re, '<a href="$1" target="_blank">$1</a>'); // 链接
	},3000);
</script>
</body>