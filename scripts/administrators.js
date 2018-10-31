
            $(document).ready(function () {

                //show/hide elements.

                function showHide(show) {
                    $(".adminView ").css("display", "none");
                    $(".adminAdd ").css("display", "none");
                    $(".editAdmin").css("display", "none");
                    show.css("display", "block");
                }
                ;

                /* show admins - show admin overview in main container/ show all Admins - build admins in side bar */

                showAllAdmins();
                AdminContainer();

                //button to show admin overview

                $('#showAdmins').click(function () {
                    AdminContainer();
                });

                //admin overview ajax - hide owner details if session role is not owner.

                function AdminContainer() {
                    showHide($(".adminView"));
                    $("#editAdmin").css("display", "none");
                    $('.statusMsg').html('');
                    $('.adminLists').remove();
                    $("#firstDescription").hide();
                    $.ajax({
                        type: 'GET',
                        url: '../Controllers/allAdmins.php',
                        success: function (adminsList) {
                            var admins = JSON.parse(adminsList);
                            for (i = 0; i < admins.length; i++) {
                                var adminWrapper = "<fieldset class='adminLists' style='padding-top:7px;'><h3 class='adminHeader' data-role='" + admins[i].role + "'data-admin='" + admins[i].id + "'" + ">" + admins[i].name + ", " + admins[i].role + "</h3>\n\
                                <h4 class='adminPhone'>" + admins[i].phone + "</h4><h4 class='adminEmail'>" + admins[i].email + "</h4><img class='allImages' src='../uploads/" + admins[i].image + "'/></fieldset>";
                                $('.adminView').append(adminWrapper);
                                $('#adminViewHeader').html("Admin View");
                                $(".adminView").css("display", "block");
   
                          if (sessionRole === 'manager') {
                                    $(".adminHeader").each(function (index, element) {
                                        if ($(element).attr("data-role") === "owner") {
                                            $(element).parent().css("display", "none");
                                        }
                                    });
                            }   
                                }
                        }
                    });
                    $('#showAdmins').css('display', 'none');
                }
                ;


                // destroy and rebuild Admins list on side bar - if session role is not owner his details will not show.

                function showAllAdmins() {
                    $(".wrapper").remove();
                    $.ajax({
                        type: 'GET',
                        url: '../Controllers/allAdmins.php',
                        success: function (adminsList) {
                            var admins = JSON.parse(adminsList);
                            for (i = 0; i < admins.length; i++) {
                                var adminWrapper = "<div class='admins wrapper adminlinks' data-name='" + admins[i].name + "' data-role='" + admins[i].role + "'data-admin='" + admins[i].id + "'><h6 id='adminName'>" + admins[i].name + ", " + admins[i].role + "</h6>\n\
                                <h6 class='adminsPhone'>" + admins[i].phone + "</h6><h6 class='emailHeader'>" + admins[i].email + "</h6><img class='adminsImage' src='../uploads/" + admins[i].image + "'/></div>";
   
                                    if (sessionRole === 'manager') {
       
                                    if ((admins[i].role !== 'owner')) {
                                        $('.col-xs-6').eq(0).append(adminWrapper);
                                    }
        
                                  } else {
       
                                    $('.col-xs-6').eq(0).append(adminWrapper);
      
                            }
   
                            }
                        }
                    });
                }
                ;

                // Admin details main post ajax - change img to file - show description - hide new owner input- clear msg - 

                $('body').on('click', '.adminlinks', function (e) {
                    showHide($('#showAdmins'));
                    $("#img").attr("type", "file");
                    $("#img").show();
                    $('#newOwner').val('');
                    $(".adminLists").remove();
                    $("#firstDescription").show();
                    $('#newOwner').css('display', 'none');
                    $('.statusMsg').html('');
                    var adminData = {id: this.dataset.admin};
                    var adminRole = this.dataset.role;
                    var adminName = this.dataset.name;
                    console.log(adminName);
                    console.log(sessionName);
                    $.ajax({
                        type: 'POST',
                        url: '../Controllers/adminDetails.php',
                        data: adminData,
                        success: function (admin) {
                            var admins = JSON.parse(admin);
                                    $("#editAdmin").attr("data-role", adminRole);
                                    
  //if session role is manager he can not edit other managers/ can not delete himself or change his role/ can not add manager or update other administrators to manager.
  
    if (sessionRole === 'manager') {     
                                       //if session role is manager he can not change sales to manager role. 
                                if ((admins.role === 'sales')) {
                                    $('#editAdmin').css("display", "block");
                                    $('.AdminForm').find('option[value=manager]').hide();
                                    $("#delete").css("display", "block");
                                }                              
                                else if((adminName === sessionName)&&(adminRole === 'manager')){
                                      $('#editAdmin').css("display", "block");
                                      $('.AdminForm').find('option[value=sales]').hide();
                                      $("#delete").css("display", "none");
                                } else if (adminRole === 'manager') {
                                        $('#editAdmin').css("display", "none");
                                    }
                                else {
                                    $('#editAdmin').css("display", "none");
                                }                                   
    }
   
                        
    //Owner can not delete himself(he has to change ownership) - delete hidden and edit visible.
    //
    //Owner must fill out full administrator name to change ownership after that he is redirected to login page.

    
    if (sessionRole === 'owner') {     
                                $('#editAdmin').css("display", "block");
                                if (adminRole === 'owner') {
                                    $("#delete").css("display", "none");
                                } else {
                                    $("#delete").css("display", "block");
                                }

                                //if owner edits himself owner select option is shown.

                                if (adminRole === 'owner') {
                                    $('#Owner').css('display', 'block');
                                } else {
                                    $('#Owner').css('display', 'none');
                                }

                                //if owner edits himself and the select option is not owner a new owner input field will show - owner must pick a new owner to replace or form wont submit.

                                $("#roleSelect").on('change', function (e) {
                                    var selectedOption = this[this.selectedIndex];
                                    var selectedText = selectedOption.text;
                                    if ((selectedText !== 'owner') && (adminRole === 'owner')) {
                                        $('#newOwner').css('display', 'block');
                                    } else {
                                        $('#ownerInput').val("");
                                        $('#newOwner').css('display', 'none');
                                    }
                                });
    }
                            $('#adminViewHeader').html("Admin View");
                            $('.adminHeader').html(admins.name + ", " + admins.role);
                            $('.adminPhone').html("Phone: " + admins.phone);
                            $('.adminEmail').html("Email: " + admins.email);
                            $('.adminImage').attr("src", "../uploads/" + admins.image)
                            $('.emailHeader').find('p').html(admins.email);

                            //edit button changes form to edit admin and fills all inputs with admin details - clear events - show image.

                            $('#editAdmin').click(function () {
                                showHide($(".adminAdd"));
                                $('.statusMsg').html('');
                                $("#delete").attr('data-admin', adminData.id);
                                $("#delete").off('click');
                                $("#newAdmin").off('submit');
                                $("#editAdminForm").off('submit');
                                $(".AdminForm").attr("id", "editAdminForm");
                                $('#editAdminForm').find('input[name=Aname]').val(admins.name);
                                $('#editAdminForm').find('input[name=Aphone]').val(admins.phone);
                                $('#editAdminForm').find('input[name=Aemail]').val(admins.email);
                                $('#editAdminForm').find('input[name=Apassword]').hide();
                                $('#editAdminForm').find('Label[for=Apassword]').hide();
                                $('#showImage').attr('src', "../uploads/" + admins.image + "");
                                $('#editAdminForm').find('select').val(admins.role);

                                //update admin main ajax - change bootstrap modal to save with no image - change image file to text(if you change text it will still upload default pic))

                                $("#editAdminForm").submit(function (e) {
                                    $('.saveChange').attr('id', 'saveNoImg');
                                    $('.saveChange').off('click');

                                    $('#saveNoImg').click(function (event) {
                                        event.preventDefault();
                                        $("#img").attr("type", "text");
                                        $('#showImage').attr('src', "../uploads/defualt.png");
                                        $("#img").hide();
                                        $("#img").val("#");
                                        $("#editAdminForm").submit();
                                    });

                                    e.preventDefault();

                                    //if select option is not owner/ the selected admin to edit is owner/ no new owner has been submited than show error msg.

                                    if (($('#roleSelect').val() !== 'owner') && (adminRole === 'owner') && ($('#ownerInput').val() === '')) {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">No such administrator exists!.</span>');
                                    } else if ($("#img").val() === '') {
                                        $('#exampleModal').modal({show: true});
                                        $('#exampleModalLabel').html('Are you sure you want to save without an image?');
                                    }
                                    else {
                                        var formData = new FormData(this);
                                        formData.append('id', adminData.id)
                                        $.ajax({
                                            type: 'POST',
                                            url: '../Controllers/updateAdmin.php',
                                            data: formData,
                                            contentType: false,
                                            cache: false,
                                            processData: false,
                                            success: function (msg) {
                                                if (msg === 'ok') {
                                                    if (($('#roleSelect').val() !== 'owner') && (adminRole === 'owner')) {
                                                        window.location.assign('login.php')
                                                    } else {
                                                        $('#editAdminForm')[0].reset();
                                                        $('.statusMsg').html('<span style="font-size:18px;color:#34A853">new Admin submitted successfully.</span>');
                                                        $(".adminAdd").css("display", "none");
                                                        showAllAdmins();
                                                        $('#showAdmins').click();
                                                    }
                                                }
                                                else if (msg === 'phoneErr') {
                                                    $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Phone must be 10 digits!.</span>');
                                                } else if (msg === 'nameErr') {
                                                    $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">name must be 20 letters max!.</span>');
                                                } else if (msg === 'emailErr') {
                                                    $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Please enter a correct email adress.</span>');
                                                } else if (msg === 'fileErr') {
                                                    $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">image must be up to 10 kb in size!.</span>');
                                                } else if (msg === 'adminErr') {
                                                    $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">No such administrator exists!.</span>');
                                                }
                                                else {
                                                    $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Please fill out all fields.</span>');
                                                }
                                                $(".submitBtn").removeAttr("disabled");
                                            }
                                        });
                                    }
                                });

                                //Delete button activates bootstraps Modal - saves new data and reloads page.

                                $("#delete").attr('data-toggle', 'modal');
                                $("#delete").attr('data-target', '#exampleModal');

                                $("#delete").click(function (event) {
                                    $('.saveChange').attr('id', 'deleteAdmin');
                                    $(".saveChange").off('click');
                                    $('#exampleModalLabel').html('Are you sure you want to delete this Admin?');
                                    $("#deleteAdmin").click(function (event) {
                                        event.stopPropagation();
                                                let
                                        DeleteData = {id: adminData.id};
                                        $.ajax({
                                            type: 'POST',
                                            data: DeleteData,
                                            url: '../Controllers/deleteAdmin.php',
                                            success: function (msg) {
                                                if (msg.indexOf('ok') !== -1) {
                                                    location.reload();
                                                } else {
                                                    $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Could not delete Admin.</span>');
                                                }
                                            }
                                        });
                                    });
                                });
                            });
                        }
                    });
                    $(".adminView ").css("display", "block");
                });

                //add Admin button event - change img to file - hide elements - clear image and msg - reset form.

                $("#addAdmin").click(function () {
                    showHide($(".adminAdd"));
                    $("#img").attr("type", "file");
                    $("#img").show();
                    $('#showAdmins').css('display', 'block');
                    $('#newOwner').css('display', 'none');
                    $('#editAdminForm').find('input[name=Apassword]').show();
                    $('#editAdminForm').find('Label[for=Apassword]').show();
                    $("#delete").css("display", "none")
                    $("#newAdmin").off('submit');
                    $("#editAdminForm").off('submit');
                    $(".AdminForm").attr("id", "newAdmin");
                    $(".AdminForm")[0].reset();
                    $('#showImage').attr('src', "");
                    $('.statusMsg').html('');

   
    if (sessionRole === 'manager') {    
                        $('.AdminForm').find('option[value=sales]').show();
                        $('.AdminForm').find('option[value=manager]').hide();  
    }
                
                    //add admin main ajax - change bootstrap modal to save with no image - change image file to text(if you change text it will still upload default pic))
                  
                    $("#newAdmin").on('submit', function (e) {
                        $('.saveChange').attr('id', 'saveNoImg');
                        $('.saveChange').off('click');
                        $('#saveNoImg').click(function (event) {
                            event.preventDefault();
                            $("#img").attr("type", "text");
                            $('#showImage').attr('src', "../uploads/defualt.png");
                            $("#img").hide();
                            $("#img").val("#");
                            $("#newAdmin").submit();
                        });
                        
                        e.preventDefault();
                        if ($("#img").val() === '') {
                            $('#exampleModal').modal({show: true});
                            $('#exampleModalLabel').html('Are you sure you want to save without an image?');
                        } else {
                            $.ajax({
                                type: 'POST',
                                url: '../Controllers/addAdmin.php',
                                success: function (msg) {
                                    if (msg === 'ok') {
                                        $('#newAdmin')[0].reset();
                                        $('.statusMsg').html('<span style="font-size:18px;color:#34A853">new Admin submitted successfully.</span>');
                                        $(".adminAdd").css("display", "none");
                                        showAllAdmins();
                                        AdminContainer();
                                    } else if (msg === 'phoneErr') {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Phone must be 10 digits!.</span>');
                                    } else if (msg === 'nameErr') {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">name must be 20 letters max!.</span>');
                                    } else if (msg === 'passErr') {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">password must be between 10 and 15 letters.</span>');
                                    } else if (msg === 'emailErr') {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Please enter a correct email adress.</span>');
                                    } else if (msg === 'fileErr') {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">image must be up to 10 kb in size!.</span>');
                                    }
                                    else {
                                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Please fill out all fields.</span>');
                                    }
                                    $(".submitBtn").removeAttr("disabled");
                                },
                                data: new FormData(this),
                                contentType: false, cache: false,
                                processData: false
                            });
                        }
                    });
                });
                
                //file type validation
                $("#img").change(function (input) {
                    var file = this.files[0];
                    var imagefile = file.type;
                    var match = ["image/jpeg", "image/png", "image/jpg"];
                    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
                        $('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Please select a valid image file!.</span>');
                        $("#img").val('');
                        return false;
                    }
                    var reader = new FileReader();
                    reader.onload = function ()
                    {
                        $('#showImage').attr('src', reader.result);
                    };
                    reader.readAsDataURL(event.target.files[0]);
                });
            });