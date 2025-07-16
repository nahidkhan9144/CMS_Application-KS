@extends('welcome')

@section('content')
<div id="login" class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
  <div id="login-box" class="bg-white shadow-lg rounded-lg max-w-md w-full p-8">
    <form id="loginDiv" method="POST" action="/login" class="space-y-6">
      <h2 class="text-2xl font-semibold text-center border-b pb-4 mb-6">Sign in</h2>
      @csrf
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <div>
        <label for="userName" class="block mb-2 text-sm font-medium text-gray-700">User Name</label>
        <input
          type="text"
          id="userName"
          name="username"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
          placeholder="Enter your username" />
      </div>

      <div>
        <label for="pass" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
        <input
          type="password"
          id="pass"
          name="pass"
          required
          class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
          placeholder="Enter your password" />
      </div>

      <div class="flex justify-center">
        <button
          type="button"
          onclick="btnClick()"
          class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-md transition duration-200">
          Sign in
        </button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  });

  function btnClick() {
    var username = document.getElementById("userName").value;
    var pass = document.getElementById("pass").value;

    if (username && pass) {
      $.ajax({
        url: '/logins',
        method: "POST",
        contentType: 'application/x-www-form-urlencoded',
        data: {
          username: username,
          pass: pass
        },
        success: function(response) {
          if (response.error == '0') {
            localStorage.setItem('token', response.token);
            localStorage.setItem('user_id', response.user_id); // or use response.user.id
            localStorage.setItem('user', JSON.stringify(response.user));
            Swal.fire({
              position: "top-end",
              icon: "success",
              title: response.message,
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              window.location.href = "/table";
            });
          } else {
            Swal.fire({
              position: "top-end",
              icon: "error",
              title: response.message,
              showConfirmButton: false,
              timer: 1500
            });
          }
        }
      });
    } else {
      Swal.fire({
        position: "top-end",
        icon: "error",
        title: "Please fill all required fields",
        showConfirmButton: false,
        timer: 1500
      });
    }
  }
</script>
@endpush