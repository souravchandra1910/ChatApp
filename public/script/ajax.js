
// Function to get otp.
function getOtp(e) {
  e.preventDefault();
  let email_id = $('#email_id').val();
  let first_name = $('#first_name').val();
  let last_name = $('#last_name').val();
  let password = $('#password').val();
  alert(email_id+" "+first_name+" "+last_name+" "+password);
  $.ajax({
    type: "post",
    url: "Ajax/Ajax-register.php",
    data: {
      email_id: email_id,
      first_name: first_name,
      last_name: last_name,
      password: password
    },
    success: function (data) {
      if (data == '') {
        $('#msg').addClass('red').text('An Error Occured');
      }
      else if (data == 'User Exists') {
        $('#msg').addClass('red').text('User Exists');
      }
      else if (data == 'Invalid UserInput') {
        $('#msg').addClass('red').text('Invalid UserInput');
      }
      else {
        $('.signup-body').html(data);
      }
    },
    error: function () {
      alert('Error')
    }
  });
}

// Function call.
$(document).on('submit', '#register-form', getOtp);

// Function to getReset
function getResetOtp(e) {
  e.preventDefault();
  let email_id = $('#email_id').val();
  $.ajax({
    type: "post",
    url: "Ajax/Ajax-reset.php",
    data: {
      email_id: email_id
    },
    success: function (data) {
      if (data == '') {
        $('#msg').addClass('red').text('An Error Occured');
      }
      else if (data == "Email Id doesn't exists") {
        $('#msg').addClass('red').text("Email Id doesn't exists");
      }
      else {
        $('.signup-body').html(data);
      }
    },
    error: function () {
      alert('Error')
    }
  });
}

$(document).on('submit', '#reset-form', getResetOtp);

// Function to load data,
function preloadData() {
  $.ajax({
    url: "Ajax/Ajax-preload.php",
    type: "POST",
    success: function (data) {
      $(".contents").html(data);
    }
  });
}

$(window).on('load',preloadData);


function closeChat() {
  document.getElementById("chat-box").style.display = "none";
}

// Function to toggle chat box visibility
function toggleChatBox() {
  var chatBox = document.getElementById("chat-box");
  if (chatBox.style.display === "none") {
    chatBox.style.display = "block"; // Show the chat box
  } else {
    chatBox.style.display = "none"; // Hide the chat box
  }
}

function fetchMessages() {
  var sender_email = $('#sender').val();
  var receiver_email = $('#receiver').val();
  $.ajax({
    url: 'Ajax/Ajax-fetch_messages.php',
    type: 'POST',
    data: { sender_email: sender_email, receiver_email: receiver_email },
    success: function (data) {
      $('#chat-box-body').html(data);
      scrollChatToBottom();
    }
  });
}


// Function to scroll the chat box to the bottom
function scrollChatToBottom() {
  var chatBox = $('#chat-box-body');
  chatBox.scrollTop(chatBox.prop("scrollHeight"));
}


$(document).ready(function () {
  // Fetch messages every 3 seconds
  fetchMessages();
  setInterval(fetchMessages, 3000);
});


// Submit the chat message

function insertMessage(e){
  e.preventDefault();
  let sender_email = $('#sender').val();
  let receiver_email = $('#receiver').val();
  let message = $('#message').val();
  $.ajax({
    url: 'Ajax/Ajax-submit_message.php',
    type: 'POST',
    data: { sender_email: sender_email, receiver_email: receiver_email, message: message },
    success: function () {
      $('#message').val('');
       // Fetch messages after submitting
      fetchMessages();
    },
    error:function(){
      alert("Error");
    }
  });
}

$(document).on('submit', '#chat-form', insertMessage);


function selectedUser() {
  let user_id = $(this).data('userid');
  $.ajax({
    url: 'Ajax/Ajax-selectUser.php',
    type: 'POST',
    data: { user_id:user_id},
    success: function () {
      preloadData();
    },
    error: function () {
      alert("Error");
    }
  });
}
$(document).on('click', '.selected', selectedUser);
