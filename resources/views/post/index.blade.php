@extends('welcome')
@section('content')
<div class="container">
    <div class="p-4 flex justify-center">
        <div class="row">
            <h1 class="text-center">All Books List</h1>
            <div class="container mx-auto">
                <div class="flex justify-between items-center">
                    <!-- Left side button -->
                    <button onclick="openCreateModal()" class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded">
                        <i class="bi bi-plus-circle"></i> Add
                    </button>

                    <!-- Right side button -->
                    <button onclick="logout()" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </div>
            </div>



            <table class="min-w-full border border-gray-300 rounded-md overflow-hidden">
                <thead class="bg-gray-100 border-b border-gray-300">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Title</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Slug</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Content</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Summary</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Published Date</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Author Name</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Update</th>
                        <th class="px-4 py-2 text-center text-sm font-medium text-gray-700">Delete</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($data as $post)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-900 truncate max-w-xs">{{ $post->title }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900 truncate max-w-xs">{{ $post->slug }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900 truncate max-w-sm">{{ $post->content }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900 truncate max-w-xs">{{ $post->summary }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ ucfirst($post->status) }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $post->published_date }}</td>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $post->author_name }}</td>

                        <td class="px-4 py-2 text-center">
                            <button type="button" class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500" onclick="updateData({{ $post->id }}, 'update')">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <form action="{{ route('delete.post', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


            <div class="text-center mt-5">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>


<div id="createModal" class="fixed inset-0 z-50 hidden items-center justify-center scrollbar">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 md:mx-auto">

        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h2 class="text-xl font-semibold text-gray-800">Add New Book Details</h2>
            <button onclick="closeCreateModal()" class="text-gray-500 hover:text-red-600 text-2xl leading-none">&times;</button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 max-h-[70vh] overflow-y-auto">
            <form method="POST" id="createForm" class="space-y-4">
                @csrf


                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title" class="mt-1 w-full border border-gray-300 rounded-md p-2" />
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                        <div class="flex gap-2">
                            <input type="text" id="slug" name="slug" class="mt-1 flex-1 border border-gray-300 rounded-md p-2 bg-gray-100" readonly disabled />
                            <button type="button" onclick="generateSlug('create')" class="mt-1 px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                Generate
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="author_name" class="block text-sm font-medium text-gray-700">Author Name</label>
                        <input type="text" id="author_name" name="author_name" class="mt-1 w-full border border-gray-300 rounded-md p-2" />
                    </div>

                    <div>
                        <label for="published_date" class="block text-sm font-medium text-gray-700">Published Date</label>
                        <input type="date" id="published_date" name="published_date" class="mt-1 w-full border border-gray-300 rounded-md p-2" />
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="status" name="status" class="mt-1 w-full border border-gray-300 rounded-md p-2">
                            <option value="Draft">Draft</option>
                            <option value="Published">Published</option>
                            <option value="Archived">Archived</option>
                        </select>
                    </div>

                    <div>
                        <label for="summary" class="block text-sm font-medium text-gray-700">Summary</label>
                        <div class="flex gap-2">
                            <textarea id="summary" name="summary" rows="2" class="mt-1 flex-1 border border-gray-300 rounded-md p-2" readonly></textarea>
                            <button type="button" onclick="generateSummary('create')" class="mt-1 px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                Generate
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea id="content" name="content" rows="4" class="mt-1 w-full border border-gray-300 rounded-md p-2"></textarea>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-3 border-t px-6 py-4">
            <button onclick="closeCreateModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancel</button>
            <button onclick="create()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">Add</button>
        </div>
    </div>
    </form>
</div>




<div id="updateModal" class="fixed inset-0 z-50 hidden items-center justify-center scrollbar">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl mx-4 md:mx-auto">

        <!-- Modal Header -->
        <div class="flex justify-between items-center border-b px-6 py-4">
            <h2 class="text-xl font-semibold text-gray-800">Update Book Details</h2>
            <button onclick="closeUpdateModal()" class="text-gray-500 hover:text-red-600 text-2xl leading-none">&times;</button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 max-h-[70vh] overflow-y-auto">
            <form method="POST" id="updateForm" class="space-y-4">
                @csrf
                <input type="hidden" id="id" name="id">
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="utitle" name="utitle" class="w-full mt-1 p-2 border rounded-md" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Slug</label>
                        <div class="flex gap-2">

                            <input type="text" id="uslug" name="uslug" class="w-full mt-1 p-2 border rounded-md bg-gray-100" readonly />
                            <button type="button" onclick="generateSlug('update')" class="mt-1 px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                Generate
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Author Name</label>
                        <input type="text" id="uauthor_name" name="uauthor_name" class="w-full mt-1 p-2 border rounded-md" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Published Date</label>
                        <input type="date" id="upublished_date" name="upublished_date" class="w-full mt-1 p-2 border rounded-md" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select id="ustatus" name="ustatus" class="w-full mt-1 p-2 border rounded-md">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Summary</label>
                        <div class="flex gap-2">

                            <textarea id="usummary" name="usummary" rows="2" class="w-full mt-1 p-2 border rounded-md" readonly></textarea>
                            <button type="button" onclick="generateSummary('update')" class="mt-1 px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                Generate
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea id="ucontent" name="ucontent" rows="4" class="w-full mt-1 p-2 border rounded-md"></textarea>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end gap-3 border-t px-6 py-4">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
            <button type="button" id="updatebtn" onclick="update()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const userId = localStorage.getItem('user_id');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function validatePostForm(postData) {
        const errors = [];

        // 1. Required fields
        if (!postData.title || postData.title.trim() === "") {
            errors.push("Title is required.");
        }

        if (!postData.slug || postData.slug.trim() === "") {
            errors.push("Slug is required.");
        }

        if (!postData.content || postData.content.trim() === "") {
            errors.push("Content is required.");
        }

        if (!postData.status || !["Draft", "Published", "Archived"].includes(postData.status)) {
            errors.push("Status must be Draft, Published, or Archived.");
        }

        if (!postData.author_name || postData.author_name.trim() === "") {
            errors.push("Author Name is required.");
        }

        if (!postData.user_id || isNaN(postData.user_id)) {
            errors.push("Valid User ID is required.");
        }

        // 2. Optional: max length validations (like Laravel)
        if (postData.title && postData.title.length > 255) {
            errors.push("Title must be at most 255 characters.");
        }

        if (postData.slug && postData.slug.length > 255) {
            errors.push("Slug must be at most 255 characters.");
        }

        if (postData.author_name && postData.author_name.length > 255) {
            errors.push("Author name must be at most 255 characters.");
        }

        // 3. Optional: published_date format check
        if (postData.published_date && !/^\d{4}-\d{2}-\d{2}$/.test(postData.published_date)) {
            errors.push("Published date must be in YYYY-MM-DD format.");
        }

        return errors;
    }


    function generateSlug(type) {
        if (type === 'create') {
            var title = $('#title').val().trim();
        } else if (type === 'update') {
            var title = $('#utitle').val().trim();
        } else {
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: 'Invalid type for slug generation.',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        if (title == '') {
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: 'Please enter a title first.',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        $.ajax({
            url: '/generate-slug',
            method: 'POST',
            data: JSON.stringify({
                title: title
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.slug) {
                    if (type === 'create') {
                        $('#slug').val(response.slug);
                    } else if (type === 'update') {
                        $('#uslug').val(response.slug);
                    }
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: 'Failed to generate slug.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            },
            error: function(xhr) {
                console.error('Error generating slug:', xhr);
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: 'Something went wrong while generating the slug.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    function generateSummary(type) {
        if (type === 'create') {
            var title = $('#title').val().trim();
        } else if (type === 'update') {
            var title = $('#utitle').val().trim();
        } else {
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: 'Invalid type for slug generation.',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        if (title == '') {
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: 'Please enter a title first.',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }
        $.ajax({
            url: '/generate-summary',
            method: 'POST',
            data: JSON.stringify({
                summary: summary
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.summary) {
                    if (type === 'create') {
                        $('#summary').val(response.summary);
                    } else if (type === 'update') {
                        $('#usummary').val(response.summary);
                    }
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: 'Failed to generate summary.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            },
            error: function(xhr) {
                console.error('Error generating summary:', xhr);
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: 'Something went wrong while generating the summary.',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }

    function closeUpdateModal() {
        $('#updateModal').addClass('hidden');
    }

    function openCreateModal() {
        $('#createModal').removeClass('hidden');
    }

    function closeCreateModal() {
        $('#createModal').addClass('hidden');
    }

    function updateData(userId, param) {
        $.ajax({
            url: '/update_get_data/' + userId,
            type: 'GET',
            dataType: 'json',

            success: function(response) {
                if (response != '') {
                    if (param == 'view') {
                        $("#updatebtn").hide();
                        $("#closebtn").hide();
                    } else {
                        $("#updatebtn").show();
                        $("#closebtn").show();
                    }
                    document.getElementById('updateModal').classList.remove('hidden');

                    var updatedata = response;
                    $("#id").val(response.id);
                    $("#utitle").val(response.title);
                    $("#uslug").val(response.slug);
                    $("#ucontent").val(response.content);
                    $("#usummary").val(response.summary);
                    $("#ustatus").val(response.status);
                    $("#upublished_date").val(response.published_date);
                    $("#uauthor_name").val(response.author_name);
                } else {
                    show_snack("no data found");
                }
                // debugger;
                console.log(response);
                // Handle the success response
            },
            error: function(error) {
                console.log(error);
                // Handle the error response
            }
        });
    }

    function update() {
        $("#msg1").html("");
        const id = $('#id').val();
        const data = {
            title: $('#utitle').val(),
            slug: $('#uslug').val(),
            content: $('#ucontent').val(),
            summary: $('#usummary').val(),
            status: $('#ustatus').val(),
            published_date: $('#upublished_date').val(),
            author_name: $('#uauthor_name').val()
        };
        $.ajax({
            url: '/post_update/' + id,
            method: "PUT",
            timeout: 0,
            headers: {
                "Content-Type": "application/json",
            },
            data: JSON.stringify(data),
            success: function(res) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: 'Post updated successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "/table";
                });
                closeUpdateModal();

            },
            error: function(xhr) {
                console.error("Update error:", xhr);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: 'Failed',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "/table";
                });
            }
        });
    }

    function create() {
        const postData = {
            title: $('#title').val(),
            slug: $('#slug').val(),
            content: $('#content').val(),
            summary: $('#summary').val(),
            status: $('#status').val(),
            published_date: $('#published_date').val(),
            author_name: $('#author_name').val(),
            user_id: userId
        };

        const validationErrors = validatePostForm(postData);
        if (validationErrors.length > 0) {
            Swal.fire({
                position: "top-end",
                icon: "error",
                title: "Validation Errors",
                text: validationErrors.join("\n"),
                showConfirmButton: true
            });
            return;
        }
        $.ajax({
            url: '/create_post',
            method: "POST",
            timeout: 0,
            headers: {
                "Content-Type": "application/json",
            },
            data: JSON.stringify(postData),
            success: function(response) {
                if (response != '') {
                    $('#updateModal').modal('hide');
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "/table";
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "/table";
                    });
                }

            },
        });
    }

    function logout() {
        const token = localStorage.getItem('token');

        if (!token) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: 'You are not logged in.',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }

        $.ajax({
            url: '/logout',
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token
            },
            success: function(response) {
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "/table";
                });


                localStorage.removeItem('token');
                localStorage.removeItem('user');
                localStorage.removeItem('user_id');

                window.location.href = '/';
            },
            error: function(xhr) {
                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Logout failed.",
                    showConfirmButton: false,
                    timer: 1500
                });
                console.error(xhr.responseText);
            }
        });
    }
</script>
@endpush