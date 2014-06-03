_chkdataResourse = function(){
    var chk = true;
    if(chk == true){
        chk = isFilledSelect(document.getElementById("ddlcategory"),0,"Please select a subject",0,"errormsg");
    }
    if(chk == true){
        chk = isFilledText(document.getElementById("txttopic"), "", "Topic title can't be left blank.", "errormsg");
    }
    if(chk == true){
        chk = isFilledText(document.getElementById("topicimage"), "", "Image can't be left blank.", "errormsg");
            var flName = document.getElementById("topicimage").value;
            var flParts = flName.split(".");
            var flExtn = flParts[flParts.length - 1].toLowerCase();
            if(flName != "" && chk == true)
            {
                if(flExtn != "jpg" && flExtn != "jpeg" && flExtn != "gif" && flExtn != "png")
                {
                    document.getElementById("validateimage").innerHTML = "Please upload jpg, jpeg, gif or png files.";
                     chk = false;
                }
            }
    }
     if(chk == true){
        chk = isFilledText(document.getElementById("classwrkTime"), "", "Please fill the class work hours to complete the topic", "errormsg");
    }
     if(chk == true){
        chk = isFilledText(document.getElementById("homewrkTime"), "", "Please fill the home work hours to complete the topic", "errormsg");
    }
    if(chk == true){
        chk = isCBoxChecked(document.getElementsByName("grade[]"), 1, "Select grade check box atleast one", 0, "errormsg");
    }
    //if(chk == true){
    //    chk = isCBoxChecked(document.getElementsByName("curriculum[]"), 1, "Select curriculum check box atleast one", 0, "errormsg");
    //}
    if(chk == true){
        chk = isFilledText(document.getElementById("topicdesc"), "", "Topic description can't be left blank.", "errormsg");
    }
    return chk;
 }
 
 
_chkdataResourseEdit = function(){
    if(chk == true){
        chk = isFilledSelect(document.getElementById("ddlchapter"),0,"Please select a chapter",0,"0");
    }

    if(chk == true){
        chk = isFilledText(document.getElementById("txttopic"), "", "Topic can't be left blank.", "");
    }
      
    if(chk == true){
        chk = isFilledText(document.getElementById("topicdesc"), "", "Topic description can't be left blank.", "");
    }
     
    //if(chk == true){
    //    chk = isFilledText(document.getElementById("topicimage"), "", "Image can't be left blank.", "");
    //        var flName = document.getElementById("topicimage").value;
    //        var flParts = flName.split(".");
    //        var flExtn = flParts[flParts.length - 1].toLowerCase();
    //        if(flName != "" && chk == true)
    //        {
    //            if(flExtn != "jpg" && flExtn != "jpeg" && flExtn != "gif" && flExtn != "png")
    //            {
    //                document.getElementById("validateimage").innerHTML = "Please upload jpg, jpeg, gif or png files.";
    //                 chk = false;
    //            }
    //        }
    //}
    if(chk == true){
        chk = isFilledText(document.getElementById("txtintro"), "", "Topic Introdction can't be left blank.", "");
    }
    if(chk == true){
        chk = isCBoxChecked(document.getElementsByName("grade[]"), 1, "Select Grade check box atleast one", 0, "");
    }
    //if(chk == true){
    //    chk = isCBoxChecked(document.getElementsByName("curriculum[]"), 1, "Select Curriculum check box atleast one", 0, "");
    //}
    if(chk == true){
        chk = isFilledText(document.getElementById("classwrkTime"), "", "Please fill the Class work hours to complete the lession", "");
    }
     if(chk == true){
        chk = isFilledText(document.getElementById("homewrkTime"), "", "Please fill the Home work hours to complete the lession", "");
    }
    //if(chk == true){
    //    chk = isFilledSelect(document.getElementById("status"), "", "Please choose the status", "");
    //}
	return chk;
 }


_validateresource = function(){
    
    var chk =true;
    if(chk == true){
        chk = isFilledText(document.getElementById("resourcetitle"), "", "Please fill the resource title", "errormsg");
    }
    if(chk == true){
        chk = isFilledText(document.getElementById("txtContentIntro"), "", "Please fill the resource description", "errormsg");
    }  
    return chk;
}

_validatequestion = function(){
   
    var chk = true;
    if(chk == true){
         chk = isFilledSelect(document.getElementById("ddltesttype"),0,"Please choose the test type",0,"0");
    }
    if(chk == true){
	chk = isFilledText(document.getElementById("txtquestion"), "", "Question can't be left blank.", "");
    }
    //if(chk == true){
    //    chk = isFilledText(document.getElementById("txtoptionone"), "", "Option one can't be left blank.", "");
    //}
    //if(chk == true){
    //    chk = isFilledText(document.getElementById("txtoptiontwo"), "", "Option two can't be left blank.", "");
    //}
    // if(chk == true){
    //    chk = isFilledText(document.getElementById("txtoptionthree"), "", "Option three can't be left blank.", "");
    //}
    // if(chk == true){
    //    chk = isFilledText(document.getElementById("txtoptionfour"), "", "Option four can't be left blank.", "");
    //}
    //if(chk == true){
    //    chk = isFilledText(document.getElementById("txtexplanation"), "", "Explanation can't be left blank.", "");
    //}
    if(chk == true){
        chk = isFilledSelect(document.getElementById("ddlAnsOption"),0,"0", "Please select one option",0, "0");
    }
    if(chk == true){
        chk = isFilledSelect(document.getElementById("ddlstatus"), 0, "Please select the status",0, "0");
    }
    return chk;
}

_validateResetPassword = function(){
   
    document.getElementById("errormsg").innerHTML = "";
    var chk = true;
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtNPassword"), "", "New Password can't be left blank.", "errormsg");
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtNCPassword"),"", "Confirm your password.", "errormsg");
    if(chk == true){
	if(document.getElementById("txtNPassword").value.trim() != document.getElementById("txtNCPassword").value.trim()){
	    //alert("Passwords are not matching");
	     document.getElementById("errormsg").innerHTML = "Passwords are not matching";
	    chk = false;
	}
    }
    return chk;
}

_validateChangePassword = function(){
   
    document.getElementById("errormsg").innerHTML = "";
    var chk = true;
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtNewPassword"), "", "New Password can't be left blank.", "errormsg");
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtConfirmPassword"),"", "Confirm your password.", "errormsg");
    return chk;
}


_chkuserDetails = function(){
    
    document.getElementById('errormsg').innerHTML = "";
    var chk = true; 
    if (chk == true)
	    chk = isFilledText(document.getElementById("txtFName"), "", "Enter your first name.", "errormsg");
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtLName"), "", "Enter your last name.", "errormsg");
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtEmailID"), "", "Enter your Email-Id.", "errormsg");
    if(chk == true)
	    chk = isEmailAddr(document.getElementById("txtEmailID"), "Invalid Email ID.", "errormsg");
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtPassword"), "", "Enter your password.", "errormsg");
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtUserName"), "", "Enter your user name.", "errormsg");
    if(chk == true)
	    chk = isFilledSelect(document.getElementById("ddlGender"), 0, "Select your Gender.",0, "errormsg");
    if(chk == true)
	    chk = isFilledSelect(document.getElementById("ddlStatus"), 0, "Select your Status.",0, "errormsg");
    if(chk == true)
	    chk = isFilledSelect(document.getElementById("ddlTypeUser"), 0, "Select your user type.",0, "errormsg");
    return chk;
};


_chkuserDetailsedit = function(){
    
    document.getElementById('errormsg').innerHTML = "";
    var chk = true; 
    if (chk == true)
	    chk = isFilledText(document.getElementById("txtFName"), "", "Enter your first name.", "errormsg");
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtLName"), "", "Enter your last name.", "errormsg");
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtEmailID"), "", "Enter your Email-Id.", "errormsg");
    if(chk == true)
	    chk = isEmailAddr(document.getElementById("txtEmailID"), "Invalid Email ID.", "errormsg");
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtPassword"), "", "Enter your password.", "errormsg");
    if(chk == true)
	    chk = isFilledText(document.getElementById("txtUserName"), "", "Enter your user name.", "errormsg");
    return chk;
};

_validatechapter  = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledSelect(document.getElementById("ddlcategory"), 0, "Select your Subject.",0, "errormsg");
    if (chk == true)
	chk = isFilledText(document.getElementById("txtchapter"), "", "Chapter title can't be left blank.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtchapterdescription"), "", "Chapter description can't be left blank.", "errormsg");
    if(chk == true)
        chk = isFilledText(document.getElementById("txtchapterimage"), "", "Image can't be left blank.", "errormsg");
    //if(chk == true)
//    chk = isFilledText(document.getElementById("hdIsValidSlug"), "0", "Slug is blank/duplicated.", "errormsg");
	//var flName = document.getElementById("topicimage").value;
	//var flParts = flName.split(".");
	//var flExtn = flParts[flParts.length - 1].toLowerCase();
	//if(flName != "" && chk == true)
	//{
	//    if(flExtn != "jpg" && flExtn != "jpeg" && flExtn != "gif" && flExtn != "png")
	//    {
	//        document.getElementById("validateimage").innerHTML = "Please upload jpg, jpeg, gif or png files.";
	//         chk = false;
	//    }
	//}
    return chk;
};
_validateEditchapter  = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
//    if(chk == true)
//	chk = isFilledSelect(document.getElementById("ddlcategory"), 0, "Select your Subject.",0, "errormsg");
    if (chk == true)
	chk = isFilledText(document.getElementById("txtchapter"), "", "Chapter title can't be left blank.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtchapterdescription"), "", "Chapter description can't be left blank.", "errormsg");
    //if(chk == true){
    //    chk = isFilledText(document.getElementById("txtchapterimage"), "", "Image can't be left blank.", "errormsg");
            //var flName = document.getElementById("topicimage").value;
            //var flParts = flName.split(".");
            //var flExtn = flParts[flParts.length - 1].toLowerCase();
            //if(flName != "" && chk == true)
            //{
            //    if(flExtn != "jpg" && flExtn != "jpeg" && flExtn != "gif" && flExtn != "png")
            //    {
            //        document.getElementById("validateimage").innerHTML = "Please upload jpg, jpeg, gif or png files.";
            //         chk = false;
            //    }
            //}
    //}
    return chk;
};

_validatecategory = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txtcategory"), "", "Subject title can't be left blank.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("prefix"), "", "Prefix can't be left blank.", "errormsg");
	return chk;
};
_validateEditcategory = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txtcategoryUp"), "", "Subject title can't be left blank.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("prefix"), "", "Prefix can't be left blank.", "errormsg");
	return chk;
};

_validateCurriculum = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txtcurriculum"), "", "Curriculum title can't be left blank.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtcurriculumID"), "", "Curriculum ID can't be left blank.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("ddlcurrentyear"), "0", "Current year can't be left blank.", "errormsg");
    if(chk == true){
	chk = isFilledText(document.getElementById("ddlnextyear"), "0", "Next year can't be left blank.","errormsg");
	var curyear = document.getElementById("ddlcurrentyear").value;
	var nextyear = document.getElementById("ddlnextyear").value;
	if (curyear > nextyear){
	    document.getElementById('errormsg').innerHTML = "Next year can't be smaller than current year";
	    chk = false;
	}
    }
    if(chk == true)
	chk = isFilledText(document.getElementById("class"), "", "Class title can't be left blank.", "errormsg");
    return chk;
};

_validateEditgrade  = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txtgradeUp"), "", "Grade title can't be left blank.", "errormsg");
	return chk;
};
_validateAddgrade  = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txtgrade"), "", "Grade title can't be left blank.", "errormsg");
	return chk;
};
_validateEditTag  = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txttagUp"), "", "Tag title can't be left blank.", "errormsg");
	return chk;
};
_validateAddTag  = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txttag"), "", "Tag title can't be left blank.", "errormsg");
	return chk;
};
_validatesubject = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txtcategoryUp"), "", "Subject title can't be left blank.", "errormsg");
	return chk;
};
_EditTest  = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txtquestion"), "", "Question can't be left blank.", "errormsg");
	return chk;
};
_validateCity = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txtcity"), "", "Please enter city.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtcityprefix"), "", "Please enter  city prefix.", "errormsg");
    return chk;
}
_validateCenter = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txtcenter"), "", "Please enter city.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("ddlcity"), "0", "Please select one city.", "errormsg");
    return chk;
}
_validatebatch = function(){
    document.getElementById('errormsg').innerHTML = "";
    var chk = true;
    if(chk == true)
	chk = isFilledText(document.getElementById("txtbatchname"), "", "Please enter batch.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtstrength"), "", "Please enter strength.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtfacilitator"), "", "Please enter facilitator.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtbatchid"), "", "Please enter batch.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("ddlcity"), "0", "Please select one city.", "errormsg");
    return chk;
}

_chkmanagerDetails = function(){
    
    document.getElementById('errormsg').innerHTML = "";
    var chk = true; 
    if (chk == true)
	chk = isFilledText(document.getElementById("txtManagerName"), "", "Please enter your name.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtManagerID"), "", "Please enter your id.", "errormsg");
//    if(chk == true)
//	 chk = isFilledSelect(document.getElementById("ddlcity"), 0, "Select your city.",0, "errormsg");
//    if(chk == true)
//	chk = isFilledText(document.getElementById("ddlcurriculum"), 0, "Select curriculum.",0, "errormsg");
//     if(chk == true)
//	chk = isFilledText(document.getElementById("ddlcenter"), 0, "Please select center.",0, "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtemailid"), "", "Please enter your email-id.", "errormsg");
    if(chk == true)
	chk = isEmailAddr(document.getElementById("txtemailid"), "Invalid email-id.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtPhone"), "", "Please Enter your phone number.", "errormsg");
//    if(chk == true)
//	chk = isFilledSelect(document.getElementById("ddlGender"), 0, "Select your Gender.",0, "errormsg");    
    return chk;
};
_chkteacherDetails = function(){
    
    document.getElementById('errormsg').innerHTML = "";
    var chk = true; 
    if (chk == true)
	chk = isFilledText(document.getElementById("txtTeacherName"), "", "Please enter your name.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtTeacherID"), "", "Please enter your id.", "errormsg");
//    if(chk == true)
//	 chk = isFilledSelect(document.getElementById("ddlcity"), 0, "Select your city.",0, "errormsg");
//    if(chk == true)
//	chk = isFilledText(document.getElementById("ddlcurriculum"), 0, "Select curriculum.",0, "errormsg");
//     if(chk == true)
//	chk = isFilledText(document.getElementById("ddlcenter"), 0, "Please select center.",0, "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtemailid"), "", "Please enter your email-id.", "errormsg");
    if(chk == true)
	chk = isEmailAddr(document.getElementById("txtemailid"), "Invalid email-id.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtPhone"), "", "Please Enter your phone number.", "errormsg");
//    if(chk == true)
//	chk = isFilledSelect(document.getElementById("ddlGender"), 0, "Select your Gender.",0, "errormsg");    
    return chk;
};

_chkstudentDetails = function(){
    
    document.getElementById('errormsg').innerHTML = "";
   var chk = true;
    if(chk == true)
	chk = isFilledSelect(document.getElementById("ddlBatch"), 0, "Select your batch.",0, "errormsg");
    if (chk == true)
	chk = isFilledText(document.getElementById("txtStudentName"), "", "Please enter your name.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtstudentID"), "", "Please enter your id.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtEmailID"), "", "Please enter your email-id.", "errormsg");
    if(chk == true)
	chk = isEmailAddr(document.getElementById("txtEmailID"), "Invalid email-id.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("textpassword"),"", "Password can't be left blank.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("textconfirmpassword"),"", "ConfirmPassword can't be left blank.", "errormsg");
    if(chk == true)
        var password = document.getElementById("textpassword").value;
	var confirmpassword = document.getElementById("textconfirmpassword").value;
	if (password == confirmpassword){
	    chk = isFilledText(document.getElementById("txtPhone"), "", "Please Enter your phone number.", "errormsg");
	}
	else{
	    document.getElementById("errormsg").innerHTML = "Passwords don't match.";
	    chk = false;
	}
    if(chk == true)
	chk = isFilledSelect(document.getElementById("ddlGender"), 0, "Select your Gender.",0, "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtboard"), "", "Please select board.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("txtschool"), "", "Please enter your  school.", "errormsg");
    if(chk == true)
	chk = isFilledText(document.getElementById("textaddress"), "", "Please enter your address.", "errormsg");

    return chk;
}; 