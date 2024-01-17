<?php
require '../../connect.php';
$get_name = isset($_GET['name']) ? filter($_GET['name']) : 'Sample Name';
$get_verif = isset($_GET['code']) ? filter($_GET['code']) : '- - - - - -';
?>
<!DOCTYPE html>
<html lang="en" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		<meta charset="utf-8">
		<meta name="x-apple-disable-message-reformatting">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
		<title>Change Password Code</title>
		<link href="https://fonts.googleapis.com/css?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700" rel="stylesheet" media="screen">
		<style type="text/css">
			.hover-underline:hover{text-decoration:underline!important}@keyframes spin{to{transform:rotate(360deg)}}@keyframes ping{75%,100%{transform:scale(2);opacity:0}}@keyframes pulse{50%{opacity:.5}}@keyframes bounce{0%,100%{transform:translateY(-25%);animation-timing-function:cubic-bezier(.8,0,1,1)}50%{transform:none;animation-timing-function:cubic-bezier(0,0,.2,1)}}@media (max-width:600px){.sm-leading-32{line-height:32px!important}.sm-px-24{padding-left:24px!important;padding-right:24px!important}.sm-py-32{padding-top:32px!important;padding-bottom:32px!important}.sm-w-full{width:100%!important}}
		</style>
	</head>
	<body style="margin:0;padding:0;width:100%;word-break:break-word;-webkit-font-smoothing:antialiased;--bg-opacity:1;background-color:#eceff1;background-color:rgba(236,239,241,var(--bg-opacity));">
		<div style="display:none;"><?= $_SERVER['SERVER_NAME'] ?> Verification Code</div>
		<div role="article" aria-roledescription="email" aria-label="Change Password Code" lang="en">
			<table style="font-family:Montserrat,-apple-system,'Segoe UI',sans-serif;width:100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
				<tr>
					<td align="center" style="--bg-opacity:1;background-color:#eceff1;background-color:rgba(236,239,241,var(--bg-opacity));font-family:Montserrat,-apple-system,'Segoe UI',sans-serif;" bgcolor="rgba(236,239,241,var(--bg-opacity))">
						<table class="sm-w-full" style="font-family:'Montserrat',Arial,sans-serif;width:600px;" width="600" cellpadding="0" cellspacing="0" role="presentation">
							<tr>
								<td class="sm-py-32 sm-px-24" style="font-family:Montserrat,-apple-system,'Segoe UI',sans-serif;padding:48px;text-align:center;" align="center">

								</td>
							</tr>
							<tr>
								<td align="center" class="sm-px-24" style="font-family:'Montserrat',Arial,sans-serif;">
									<table style="font-family:'Montserrat',Arial,sans-serif;width:100%;" width="100%" cellpadding="0" cellspacing="0" role="presentation">
										<tr>
											<td class="sm-px-24" style="--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity));border-radius:4px;font-family:Montserrat,-apple-system,'Segoe UI',sans-serif;font-size:14px;line-height:24px;padding:48px;text-align:left;--text-opacity:1;color:#626262;color:rgba(98,98,98,var(--text-opacity));" bgcolor="rgba(255, 255, 255, var(--bg-opacity))" align="left">
												<p style="font-weight:600;font-size:18px;margin-bottom:0;">Hey</p>
												<p style="font-weight:700;font-size:20px;margin-top:0;--text-opacity:1;color:#ff5850;color:rgba(255,88,80,var(--text-opacity));"><?= $get_name ?>!</p>
												<p style="margin:0 0 24px;">
													We have received your request to reset your <b><?= $_SERVER['SERVER_NAME'] ?></b> password. Please copy the code below to reset your password.
												</p>
												<p style="margin:0 0 24px;">
													<pre style="font-size:34px;text-align: center;"><?= $get_verif ?></pre>
												</p>
											</td>
										</tr>
										<tr>
											<td style="font-family:'Montserrat',Arial,sans-serif;height:20px;" height="20"></td>
										</tr>
										<tr>
											<td style="font-family:Montserrat,-apple-system,'Segoe UI',sans-serif;font-size:12px;padding-left:48px;padding-right:48px;--text-opacity:1;color:#eceff1;color:rgba(236,239,241,var(--text-opacity));">

											</td>
										</tr>
										<tr>
											<td style="font-family:'Montserrat',Arial,sans-serif;height:16px;" height="16"></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</div>
	</body>
</html>