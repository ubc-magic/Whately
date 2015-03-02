    
<!DOCTYPE html>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<meta name = "viewport" content = "width=device-width, initial-scale=1.0">

<script type="text/javascript" src="graph.js" charset="utf-8"></script>

<link rel="stylesheet" href="http://www.jointjs.com/downloads/joint.min.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="graph.css">

<script type="text/javascript" src="http://www.jointjs.com/downloads/joint.min.js" ></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="bootstrap-3.3.2-dist/js/bootstrap.js" ></script> 



<title>Whatly</title>

<body>

     <div id="top_nav" class = "navbar navbar-default navbar-fixed-top" role="navigation">
	    <div class = "container-fluid">
		   <div class = "navbar-header">
		       <!--<a href= "#" calss = "navbar-brand btn btn-lg"><img src="whatly1.png" alt="whatly" width="150" height="80"></a>-->
		   	
			<button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
			    <span class="sr-only">Toggle navigation</span>
				<span class = "icon-bar"></span>
				<span class = "icon-bar"></span>
				<span class = "icon-bar"></span>
			</button>
			<ul class = "nav navbar-brand navbar-left"><a calss = "btn btn-success btn-lg">Whatly</a></ul>
		   </div>
			<div class ="collapse navbar-collapse navHeaderCollapse">
			<!--<ul class = "nav navbar-nav navbar-left"><li><a calss = "btn btn-default btn-lg" href="#">Whatly</a></li></ul>-->
	        <ul class = "nav navbar-nav navbar-right">
	            <li class = "active dropdown"><a href="#" id ='file' class= "dropdown-toggle" data-toggle = "dropdown">File <b class = "caret"></b></a>
			        <ul class = "dropdown-menu">
		                <li><a href="new-engine.php" id='new'>New</a></li>
			            <li class = "dropdown"><a href="#" id='open' class = "btn-default" data-toggle = "modal" data-target="#openModal">Graphs</a></li>
			            <li><a href="#" class="btn-default" data-toggle="modal" data-target="#beLogSaveRejectModal" id = "save-as-submit">Save as</a></li>
						<li><a href="#" class="btn-default" data-toggle="modal" data-target="#beLogSaveRejectModal" id="save-submit">Save</a></li>
						 <li><a href="#" id='print'>Print</a></li>
				    </ul>
		        </li>
			    <li class ="dropdown"><a href="#" id = 'language' class = "dropdown-toggle" data-toggle = "dropdown">Language <b class = "caret"></b></a>
			
			        <ul class = "dropdown-menu">
		                <li><a href="#" id='english' onclick="english(); return false;">English</a></li>
			            <li><a href="#" id='mandarin' onclick="mandarin(); return false;">Mandarin</a></li>
			            <li><a href="#" id='spanish' onclick="spanish(); return false;">Spanish</a></li>
			            <li><a href="#" id='french'  onclick="french(); return false;">French</a></li>
				    </ul>
		        </li>
		        <li class = "dropdown"><a href="#" id= 'help' data-toggle = "modal">Watch demo</a></li>
				<li class = "dropdown"><a href="#" id= 'help' data-toggle = "modal">About</a></li>
		        <li class="log-in" id ="log"><a href="#" class="btn btn-lg" data-toggle="modal" data-target="#logInModal">Log in</a></li>
			    <li class="register" id="reg"><a href="#" class="btn btn-lg" data-toggle="modal" data-target="#registerModal">Register</a>
				    <!--Register modal-->
					<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labeledby="registerLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
									<h4 class="modal-title" id="registerLabel">Register</h4>
								</div>
								<div class="modal-body">
									<form name="register-form" action="register-engine.php" method="POST" class="pure-form form" onsubmit ="return validateFormRegister();">
											<div class='name form-group'>
												<input type="text" placeholder="Name*" name="name" id="name-register" class="form-control">
											</div>
											<div class='e-mail form-group'>
												<input type="text" placeholder="E-mail*" name="e-mail" id="e-mail-register" class="form-control">
											</div>
											<div class='username form-group'>
												<input type="text" placeholder="User name*" name="user-name2" id="username-register" class="form-control">
											</div>
											<div class='password form-group'>
												<input type="password" placeholder="Password*"  name="password2" id="psw-register" class="form-control">
											</div>
											<div class='re-password form-group'>
												<input type="password" placeholder="Repeat password*"  name="re-password" id="rpsw-register" class="form-control">
											</div>
											<!--<input type="submit" value="Sign up" id="register-submit">-->
											<button type="submit" class="btn btn-info btn-lg">Save</button>
										</form>
								</div>
							</div>
						</div>
					</div>
   
				</li>
			   
		    </ul>
	        </div>
		</div>
	</div>
	<!--The modals-->
	
	<!--Open modal-->
	<div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="openLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
					<h4 class="modal-title" id="openLabel">Open graphs</h4>
				</div>
				<div class="modal-body" >
				    <div class="table-responsive">
					    <table class="table" id="myTable">
						    <thead>
							    <tr>
								    <th>Graph name</th>
									<th>Remove the graph</th>
								</tr>
							</thead>
							<tbody id= "graphList">
							
							</tbody>
						</table>
				    </div>
				</div>
			</div>
		</div>
	</div>
	<!--Before log in save reject-->
	<div class="modal fade" id="beLogSaveRejectModal" tabindex="-1" role="dialog" aria-labelledby="beLogSaveRejectLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
					<h4 class="modal-title" id="beLogSaveRejectLabel"></h4>
				</div>
				<div class="modal-body">
					<p id='save-as-confirm-p'>Please log in before saving the graph.</p>
				</div>
			</div>
		</div>
	</div>
	<!--Save as modal window-->
	<div class="modal fade" id="saveAsModal" tabindex="-1" role="dialog" aria-labelledby="saveAsLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
					<h4 class="modal-title" id="saveAsLabel">Save as</h4>
				</div>
				<div class="modal-body">
					<form name="save-as-form" action="save-as-engine.php" method="POST" class="pure-form form" id = "form-save-as" onsubmit ="return validateFormSaveAs();">
						<div class="form-group">
							<p id = 'save-as-p'>Please enter a title for your graph:</p>
							<input type="text" placeholder="Title" name="title" id="title-save-as" class="form-control">
						</div>
						<div>
							<input type="text" placeholder="Graph" name="graph" id="graph-txt">
						</div>
							<!--<input type="submit" value="Save-as" id = "save-as-submit">-->
							<button type="submit" class="btn btn-info btn-lg" value="Save-as" >Save</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<!--Save modal window-->
		<div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labeledby="saveLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
						<h4 class="modal-title" id="saveLabel"></h4>
					</div>
					<div class="modal-body">
						<form name="save-form" action="save-engine.php" method="POST" class="pure-form" id = "form-save"; >
							<div>
								<p id= 'save-p'>Please click on save to save the graph:</p>
								<input type="hidden" placeholder="Title" name="title" id="title-save">
							</div>
							<div>
								<input type="hidden" placeholder="Graph" name="graph" id="graph-txt-save">
							</div>
							<div>
								<input type="hidden" placeholder="Count" name="count" id="count-save">
							</div>
							<!--<input type="submit" value="Save" id = "save-submit">-->
							<button type="submit" class="btn btn-info btn-lg" value="Save">Save</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		
	<!--Save reject Modal window-->

	<div class="modal fade" id="saveRejectModal" tabindex="-1" role="dialog" aria-labelledby="saveRejectLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
					<h4 class="modal-title" id="saveRejectLabel"></h4>
				</div>
				<div class="modal-body">
					<p id='save-as-confirm-p'>Since you haven't saved this graph before you have to click on save as for saving this graph .</p>
				</div>
			</div>
		</div>
	</div>
    
    <!--Remove confirm modal-->

    <div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labeledby="removeLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="closeRemove">X</button>
						<h4 class="modal-title" id="removeLabel"></h4>
					</div>
					<div class="modal-body">
						<form name="save-form" action="remove-engine.php" method="POST" class="pure-form" id = "form-save"; >
							<div>
								<p id= 'save-p'>Are you sure you want to remove the graph?</p>
								<input type="hidden" placeholder="Title" name="title-remove" id="title-remove">
							</div>
							<!--<div>
								<input type="text" placeholder="Count" name="count" id="count-save">
							</div>-->
							<!--<input type="submit" value="Save" id = "save-submit">-->
							<button type="submit" class="btn btn-info btn-lg" value="Save">Remove</button>
						</form>
					</div>
				</div>
			</div>
		</div>	
    
    <!--Log in modal-->
	<div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="logInLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
			<h4 class="modal-title" id="logInLabel">Log In</h4>
			</div>
			<div class="modal-body">
				<form name="sign-in-form" action="log-in-engine.php" method="POST" class="pure-form form" onsubmit="return validateFormSignIn();">
					<div class='username form-group'>
						<input type="text" placeholder="email" name="email-login" id="em-log-in" class="form-control">
					</div>
					<div class='password form-group'>
						<input type="password" placeholder="Password"  name="password1" id = "psw-log-in" class="form-control">
					</div>
					<!--<input type="submit" value="Sign in" id = "sign-in-submit">-->
					<button type="submit" class="btn btn-info btn-lg">Log In</button>
				</form>
			</div>
			<div class="modal-footer">
			</div>
			</div>
		</div>
	</div> 
						
     <!--This (div) is the part that the whole javascript code would be called in-->
	 <div id="myholder"></div>
</body>

<script type="text/javascript" src="graph.js"></script>
<script type="text/javascript">
    //The code for form validation
        function validateFormSignIn() {
		    
        var usernameValidate = document.forms["sign-in-form"]["email-login"].value;
	    var passwordValidate = document.forms["sign-in-form"]["password1"].value;
		
        if ((usernameValidate == null || usernameValidate == "") || (passwordValidate == null || passwordValidate == "")) {
            alert("You must fill out your username/password!!");
            return false;
            }
			
        }
		
		function validateFormRegister() {
		
		var flag = 1;
		
        var nameValidate = document.forms["register-form"]["name"].value;
	    var emailValidate = document.forms["register-form"]["e-mail"].value;
		var usernameValidate = document.forms["register-form"]["user-name2"].value;
	    var passwordValidate = document.forms["register-form"]["password2"].value;
		var repasswordValidate = document.forms["register-form"]["re-password"].value;
		
		var nameValidateLen = nameValidate.length;
		
		var usernameValidateLen = usernameValidate.length;

        var passwordValidateLen	= passwordValidate.length;	
		var repasswordValidateLen = repasswordValidate.length;
		
		var atpos = emailValidate.indexOf("@");
        var dotpos = emailValidate.lastIndexOf(".");
		if(flag==1){
		    
		    
			if (usernameValidateLen > 17){
			    alert("You cannot have a username longer than 16 letters. choose another username.");
			    return false;
			   }
			   
            if ((nameValidate == null || nameValidate == "") || (emailValidate == null || emailValidate == "") || (usernameValidate == null || usernameValidate == "") || (passwordValidate == null || passwordValidate == "") || (repasswordValidate == null || repasswordValidate == "")) {
                alert("You must fill out all the boxes in the form!!");
                return false;
                }
			
		    if (nameValidateLen > 31){
			   alert("You cannot have the name longer than 30 letters. So please shorten your name.");
			   return false;
			   }
			   
		    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=emailValidate.length) {
                alert("Not a valid e-mail address");
                return false;
               }
			
            		
			if (!(passwordValidate == repasswordValidate)){
			    alert("Passwords don't match!!");
                return false;
			
			 } 
             
            if(passwordValidateLen > 21 || passwordValidateLen < 11){
			    alert("Please choose a password longer than 10 and shorter than 20.");
                return false;
			}			 
			
		    
		}
		
        }
		
		function validateFormSaveAs() {
		  
        var titleValidate = document.forms["save-as-form"]["title"].value;
	    
        if (titleValidate == null || titleValidate == "") {
            alert("You must fill out the title!!");
            return false;
            }
		
		var titleValidateLen = titleValidate.length;
		
		if (titleValidateLen > 16){
			alert("Please choose a title with lenght of shorter than 16");
			return false;
			   }
        }
		//Functions for changing languages
		//$('#english').click(function(){ english(); return false; });
		
		
		var log = 0;
    var language='en';
    function readCookie(name) {
	    var cookiename = name + "=";
	    var ca = document.cookie.split(';');
	    for(var i=0;i < ca.length;i++)
	    {
		    var c = ca[i];
		    while (c.charAt(0)==' ') c = c.substring(1,c.length);
		    if (c.indexOf(cookiename) == 0) return c.substring(cookiename.length,c.length);
	    }
	    return null;
    }
	
	log = readCookie('log-statue-cookie');
	user = readCookie('log-in-cookie');
		
		    var language;
			
		    function english(){
			    language = "en";
				if (log==1){
				     document.getElementById("logOut").innerHTML = "Log out";
				   }
				
				//document.getElementById("log").style.marginLeft = "830px";
				
			    document.getElementById("new").innerHTML = "New";
				document.getElementById("file").innerHTML = "File";
				document.getElementById("open").innerHTML = "Open";
				document.getElementById("save-as").innerHTML = "Save as";
				document.getElementById("save-as-leg").innerHTML = "Save as"; 
				document.getElementById("save-as-p").innerHTML = "Please enter a title for your graph:"; 
				document.getElementById("save-as-confirm-p").innerHTML = "You have saved your graph successfully."; 
				document.getElementById("save").innerHTML = "Save"; 
				document.getElementById("save-leg").innerHTML = "Save:"; 
			    document.getElementById("save-p").innerHTML = "Please click on save to save the graph:"; 
			    document.getElementById("save-err-leg").innerHTML = "Save error:"; 
			    document.getElementById("save-err-p").innerHTML = "For saving this graph you have to click on save as."; 
			    document.getElementById("print").innerHTML = "print"; 
				document.getElementById("language").innerHTML = "Language"; 
                document.getElementById("english").innerHTML = "English";
                document.getElementById("mandarin").innerHTML = "Mandarin";
                document.getElementById("spanish").innerHTML = "Spanish";
                document.getElementById("french").innerHTML = "French";	
                document.getElementById("help").innerHTML = "Help";	
                document.getElementById("manual").innerHTML = "Manual";	
                document.getElementById("tips").innerHTML = "Tips";			
                document.getElementById("log-in").innerHTML = "Log in";	
                document.getElementById("log-in-leg").innerHTML = "Sign in:";
                document.getElementById("log-error-p").innerHTML = "Please enter a correct username or password";		
                document.getElementById("register-a").innerHTML = "Register";
                document.getElementById("register-leg").innerHTML = "Register:";
                document.getElementById("reg-confirm-p").innerHTML = "Now you can log in to your account";
                document.getElementById("reg-denied-p").innerHTML = "Registration has been denied since you are using a registered e-mail or user-name.";				
				
				document.getElementById("txarea").innerHTML = "Start writing";
				
				document.getElementById("title-save-as").placeholder = "Title";
				
				document.getElementById("em-log-in").placeholder = "E-mail";
				document.getElementById("psw-log-in").placeholder = "Password";
				
				document.getElementById("name-register").placeholder = "Name*";
				document.getElementById("e-mail-register").placeholder = "E-mail*";
				document.getElementById("username-register").placeholder = "User name*";
				document.getElementById("psw-register").placeholder = "Password*";
				document.getElementById("rpsw-register").placeholder = "Repeat password*";
				
				document.getElementById("save-as-submit").value = "Save-as";
				document.getElementById("save-submit").value = "Save";
				document.getElementById("sign-in-submit").value = "Sign in";
				document.getElementById("register-submit").value = "Sign up";
				
			}
			
			function mandarin(){
			    language = "man";
				if (log==1){
				    document.getElementById("logOut").innerHTML = "注销";
				    //document.getElementById("log").style.marginLeft = "870px";
				    }
				if (log==0){
				    //document.getElementById("log").style.marginLeft = "900px";	
				   }
				
			    document.getElementById("new").innerHTML = "新";
				document.getElementById("file").innerHTML = "文件";
				document.getElementById("open").innerHTML = "开放";
				document.getElementById("save-as").innerHTML = "除";
				document.getElementById("save-as-leg").innerHTML = "除"; 
				document.getElementById("save-as-p").innerHTML = "请输入一个标题为您的图表所示："; 
				document.getElementById("save-as-confirm-p").innerHTML = "您已成功保存您的图形。"; 
				document.getElementById("save").innerHTML = "保存"; 
				document.getElementById("save-leg").innerHTML = "保存："; 
			    document.getElementById("save-p").innerHTML = "请点击保存，保存图："; 
			    document.getElementById("save-err-leg").innerHTML = "保存错误："; 
			    document.getElementById("save-err-p").innerHTML = "保存这个图，你必须点击另存为。"; 
			    document.getElementById("print").innerHTML = "打印"; 
				document.getElementById("language").innerHTML = "语言"; 
                document.getElementById("english").innerHTML = "英语";
                document.getElementById("mandarin").innerHTML = "普通话";
                document.getElementById("spanish").innerHTML = "西班牙语";
                document.getElementById("french").innerHTML = "法国";	
                document.getElementById("help").innerHTML = "救命";	
                document.getElementById("manual").innerHTML = "手册";	
                document.getElementById("tips").innerHTML = "温馨提示";			
                document.getElementById("log-in").innerHTML = "登录";	
                document.getElementById("log-in-leg").innerHTML = "登入：";
                document.getElementById("log-error-p").innerHTML = "请输入正确的用户名或密码";		
                document.getElementById("register-a").innerHTML = "注册";
                document.getElementById("register-leg").innerHTML = "注册：:";
                document.getElementById("reg-confirm-p").innerHTML = "现在，您可以在您的帐户登录";
                document.getElementById("reg-denied-p").innerHTML = "因为你使用的是已注册的电子邮件或用户名的注册已被拒绝。";	
				
				document.getElementById("txarea").innerHTML = "动笔";
				
				
                document.getElementById("title-save-as").placeholder = "称号";

                document.getElementById("em-log-in").placeholder = "电子邮件";
				document.getElementById("psw-log-in").placeholder = "密码";
				
				document.getElementById("name-register").placeholder = "名字*";
				document.getElementById("e-mail-register").placeholder = "电子邮件*";
				document.getElementById("username-register").placeholder = "用户名*";
				document.getElementById("psw-register").placeholder = "密码*";
				document.getElementById("rpsw-register").placeholder = "重复密码*";

                document.getElementById("save-as-submit").value = "另存为";	
                document.getElementById("save-submit").value = "保存";	
                document.getElementById("sign-in-submit").value = "登入";
				document.getElementById("register-submit").value = "报名";
				
			}
			
			function spanish(){
			    language = 'span';
				if (log==1){
				   	document.getElementById('logOut').innerHTML = "finalizar la sesión";
					//document.getElementById("log").style.marginLeft = "670px";
				    }
				if (log==0){
				    //document.getElementById("log").style.marginLeft = "700px";	
				   }
				   
			    document.getElementById('new').innerHTML = 'nuevo';
				document.getElementById('file').innerHTML = 'expediente';
				document.getElementById('open').innerHTML = 'abierto';
				document.getElementById('save-as').innerHTML = 'Guardar como';
				document.getElementById('save-as-leg').innerHTML = 'Guardar como'; 
				document.getElementById('save-as-p').innerHTML = 'Por favor, introduzca un título para el gráfico:'; 
				document.getElementById('save-as-confirm-p').innerHTML = 'Ha guardado tu gráfica con éxito.'; 
				document.getElementById('save').innerHTML = 'Guardar'; 
				document.getElementById('save-leg').innerHTML = 'Guardar:'; 
			    document.getElementById('save-p').innerHTML = 'Por favor, haga clic en Guardar para guardar el gráfico:'; 
			    document.getElementById('save-err-leg').innerHTML = 'Guardar error:'; 
			    document.getElementById('save-err-p').innerHTML = 'Para salvar este gráfico tienes que hacer clic en Guardar como.'; 
			    document.getElementById('print').innerHTML = 'impresión'; 
				document.getElementById('language').innerHTML = 'idioma'; 
                document.getElementById('english').innerHTML = 'Inglés';
                document.getElementById('mandarin').innerHTML = 'mandarín';
                document.getElementById('spanish').innerHTML = 'español';
                document.getElementById('french').innerHTML = 'francés';	
                document.getElementById('help').innerHTML = 'ayuda';	
                document.getElementById('manual').innerHTML = 'manual';	
                document.getElementById('tips').innerHTML = 'Consejos';			
                document.getElementById('log-in').innerHTML = 'iniciar sesión';	
                document.getElementById('log-in-leg').innerHTML = 'Registrarse:';
                document.getElementById('log-error-p').innerHTML = 'Por favor, introduzca un nombre de usuario o contraseña correcta';		
                document.getElementById('register-a').innerHTML = 'Registrarse';
                document.getElementById('register-leg').innerHTML = 'Registrarse:';
                document.getElementById('reg-confirm-p').innerHTML = 'Ahora usted puede iniciar sesión en su cuenta';
                document.getElementById('reg-denied-p').innerHTML = 'Registro ha sido negado dado que está utilizando un correo electrónico registrada o nombre de usuario.';				
			    
			
			    document.getElementById('txarea').innerHTML = "Comienza a escribir";
				
				document.getElementById('title-save-as').placeholder = 'título';
				
				document.getElementById('em-log-in').placeholder = 'Email';
				document.getElementById('psw-log-in').placeholder = 'contraseña';
				
				document.getElementById('name-register').placeholder = 'nombre*';
				document.getElementById('e-mail-register').placeholder = 'E-mail*';
				document.getElementById('username-register').placeholder = 'nombre de usuario*';
				document.getElementById('psw-register').placeholder = 'contraseña*';
				document.getElementById('rpsw-register').placeholder = 'Repita la contraseña*';
				
				document.getElementById('save-as-submit').value = 'guardar como';
				document.getElementById('save-submit').value = "guardar";
                document.getElementById('sign-in-submit').value = "registrarse";	
                document.getElementById('register-submit').value = "contratar";	
			
			}
			
			function french(){
			    language = 'frc';
				if (log==1){
                    document.getElementById('logOut').innerHTML = "déconnecter";
				    //document.getElementById("log").style.marginLeft = "700px";
				    }
				if (log==0){
				    //document.getElementById("log").style.marginLeft = "700px";	
				   }	
					
			    document.getElementById('new').innerHTML = 'nouveau';
				document.getElementById('file').innerHTML = 'fichier';
				document.getElementById('open').innerHTML = 'ouvert';
				document.getElementById('save-as').innerHTML = 'enregistrer sous';
				document.getElementById('save-as-leg').innerHTML = 'enregistrer sous'; 
				document.getElementById('save-as-p').innerHTML = 'Se il vous plaît donner un titre à votre graphique:'; 
				document.getElementById('save-as-confirm-p').innerHTML = 'Vous avez enregistré avec succès votre graphique.'; 
				document.getElementById('save').innerHTML = 'Enregistrer'; 
				document.getElementById('save-leg').innerHTML = 'Enregistrer:'; 
			    document.getElementById('save-p').innerHTML = 'Se il vous plaît cliquez sur Enregistrer pour enregistrer le graphique:'; 
			    document.getElementById('save-err-leg').innerHTML = 'Enregistrer erreur:'; 
			    document.getElementById('save-err-p').innerHTML = 'Pour sauver ce graphique, vous devez cliquer sur Enregistrer sous.'; 
			    document.getElementById('print').innerHTML = 'imprimer'; 
				document.getElementById('language').innerHTML = 'langue'; 
                document.getElementById('english').innerHTML = 'anglais';
                document.getElementById('mandarin').innerHTML = 'mandarin';
                document.getElementById('spanish').innerHTML = 'espagnol';
                document.getElementById('french').innerHTML = 'français';	
                document.getElementById('help').innerHTML = 'Aidez-Moi';	
                document.getElementById('manual').innerHTML = 'manuel';	
                document.getElementById('tips').innerHTML = 'Conseils';			
                document.getElementById('log-in').innerHTML = 'Se connecter';	
                document.getElementById('log-in-leg').innerHTML = 'Se connecter:';
                document.getElementById('log-error-p').innerHTML = "Se il vous plaît entrer un nom d'utilisateur ou mot de passe correct";		
                document.getElementById('register-a').innerHTML = 'Se enregistrer';
                document.getElementById('register-leg').innerHTML = 'Se enregistrer:';
                document.getElementById('reg-confirm-p').innerHTML = 'Maintenant, vous pouvez vous connecter à votre compte';
                document.getElementById('reg-denied-p').innerHTML = "Enregistrement a été refusé puisque vous utilisez un e-mail recommandé ou nom d'utilisateur.";				
			    
			    
				document.getElementById('txarea').innerHTML = "Commencez à écrire";
			
				document.getElementById('title-save-as').placeholder = 'titre';
				
				document.getElementById('em-log-in').placeholder = "Email";
				document.getElementById('psw-log-in').placeholder = "mot de passe";
				
				document.getElementById('name-register').placeholder = "nom*";
				document.getElementById('e-mail-register').placeholder = "Email*";
				document.getElementById('username-register').placeholder = "Nom d'utilisateur*";
				document.getElementById('psw-register').placeholder = "mot de passe*";
				document.getElementById('rpsw-register').placeholder = "Répéter le mot de passe*";
				
				document.getElementById('save-as-submit').value = 'enregistrer en tant que';
				document.getElementById('save-submit').value = "sauver";
				document.getElementById('sign-in-submit').value = "se connecter";
				document.getElementById('register-submit').value = "signer";
				 
			}
    </script>
</html> 