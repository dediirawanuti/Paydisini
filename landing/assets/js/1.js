$(function(){$('.scroll').bind('click',function(event){var $anchor=$(this);$('html, body').stop().animate({scrollTop:$($anchor.attr('href')).offset().top-0},1500,'easeInOutExpo');event.preventDefault();});});jQuery(function($){'use strict';var ContactFormApp={$contactForm:$("#ajax-form"),$contactFormBtn:$("#send"),$contactFormName:$("#name2"),$contactFormEmail:$("#email2"),$contactFormMessage:$("#message2"),$confirmMessage:$("#ajaxsuccess"),$errorMessages:$(".error"),$errorName:$("#err-name"),$errorEmail:$("#err-emailvld"),$errorMessage:$("#err-message"),$errorForm:$("#err-form"),$errorTimeout:$("#err-timedout"),$errorState:$("#err-state"),validate:function(){var error=false;var name=this.$contactFormName.val();if(name==""||name==" "||name=="Name"){this.$errorName.show(500);this.$errorName.delay(4000);this.$errorName.animate({height:'toggle'},500,function(){});error=true;}
var email_compare=/^([a-z0-9_.-]+)@([da-z.-]+).([a-z.]{2,6})$/;var email=this.$contactFormEmail.val().toLowerCase();if(email==""||email==" "||email=="E-mail"){this.$errorEmail.show(500);this.$errorEmail.delay(4000);this.$errorEmail.animate({height:'toggle'},500,function(){});error=true;}
else if(!email_compare.test(email)){this.$errorEmail.show(500);this.$errorEmail.delay(4000);this.$errorEmail.animate({height:'toggle'},500,function(){});error=true;}
var message=this.$contactFormMessage.val();if(message==""||message==" "||message=="Message"){this.$errorMessage.show(500);this.$errorMessage.delay(4000);this.$errorMessage.animate({height:'toggle'},500,function(){});error=true;}
if(error==true){this.$errorForm.show(500);this.$errorForm.delay(4000);this.$errorForm.animate({height:'toggle'},500,function(){});}
return error;},contactFormSubmit:function(obj){this.$errorMessages.fadeOut('slow');if(this.validate()==false){var data_string=$('#ajax-form').serialize();var $this=this;$.ajax({type:"POST",url:$this.$contactForm.attr('action'),data:data_string,timeout:6000,cache:false,crossDomain:false,error:function(request,error){if(error=="timeout"){$this.$errorTimeout.slideDown('slow');}
else{$this.$errorState.slideDown('slow');$this.$errorState.html('An error occurred: '+error+'');}},success:function(){$this.$confirmMessage.show(500);$this.$confirmMessage.delay(4000);$this.$confirmMessage.animate({height:'toggle'},500,function(){});$this.$contactFormName.val('');$this.$contactFormEmail.val('');$this.$contactFormMessage.val('');}});}
return false;},bindEvents:function(){this.$contactFormBtn.on('click',this.contactFormSubmit.bind(this));},init:function(){console.log('Contact form is initialized');this.bindEvents();return this;}};ContactFormApp.init({});});