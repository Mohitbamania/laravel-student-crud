<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student CRUD</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">



    <style>
        body {
            background: linear-gradient(135deg, #f0f4f7, #d9e2ec);
            font-family: 'Segoe UI', sans-serif;
        }

        .card-custom {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn-primary {
            background-color: #0056b3;
            border: none;
        }

        .btn-primary:hover {
            background-color: #004494;
        }

        .modal-header {
            border-bottom: 1px solid #dee2e6;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
        }

        .form-label {
            font-weight: 600;
        }

        .dataTables_length {
            margin-bottom: 1rem;
            margin-right: 2rem;
        }

        .dataTables_filter {
            margin-bottom: 1rem;
        }
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            display: inline-block;
            vertical-align: middle;
        }
    </style>
</head>

<body>

    <div class="container py-5">
        <div class="card card-custom">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">🎓 Student List</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                    ➕ Add Student
                </button>
            </div>

            <div class="table-responsive">
                <table id="studentsTable" class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Enrollment Number</th>
                            <th>Gender</th>
                            <th>Mobile Number</th>
                            <th>Profile Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->enrollement_no }}</td>
                                <td>{{ $student->gender }}</td>
                                <td>{{ $student->mobile_number }}</td>
                                <td>
                                    @if($student->image)
                                        <img src="{{ asset('storage/' . $student->image) }}" width="60" height="60"
                                            class="rounded-circle" />
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editStudentModal"
                                        onclick="editStudent(
                                                                                                                                            {{ $student->id }},
                                                                                                                                            {{ json_encode($student->name) }},
                                                                                                                                            {{ json_encode($student->enrollement_no) }},
                                                                                                                                            {{ json_encode($student->gender) }},
                                                                                                                                            {{ json_encode($student->mobile_number) }},
                                                                                                                                            {{ json_encode($student->email_id) }},
                                                                                                                                            {{ json_encode($student->password) }},
                                                                                                                                            {{ json_encode($student->image) }}
                                                                                                                                        )">Edit</a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm"
                                        onclick="deleteStudent({{ $student->id }})">Delete</a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New Student</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Enrollment No</label>
                            <input type="text" name="enrollement_no" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option disabled selected>Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" name="mobile_number" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email ID</label>
                            <input type="email" name="email_id" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success w-100">Add Student</button>
                        <button type="submit" class="btn btn-danger w-100">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('student.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="edit_student_id">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Edit Student</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Enrollment No</label>
                            <input type="text" name="enrollement_no" id="edit_enrollment_no" class="form-control"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="edit_gender" class="form-select" required>
                                <option disabled selected>Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" name="mobile_number" id="edit_mobile_number" class="form-control"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email ID</label>
                            <input type="email" name="email_id" id="edit_email_id" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" id="edit_password" class="form-control" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Preview Image</label>
                            <img id="edit_image_preview" src="" alt="Profile Image" class="img-thumbnail mb-2"
                                style="display: none; width: 100px; height: 100px;">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success w-100">Update Student</button>
                        <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Student Modal -->

    <form id="delete-student-form" action="{{ route('student.delete') }}" method="POST">
        @csrf

        <input type="hidden" id="delete_student_id" name="id">

    </form>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


<script>

    $(document).ready(function () {
        $('#studentsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    });

    function editStudent(studentId, name, enrollment, gender, mobile, email, password, image) {
        document.getElementById('edit_student_id').value = studentId;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_enrollment_no').value = enrollment;
        document.getElementById('edit_gender').value = gender;
        document.getElementById('edit_mobile_number').value = mobile;
        document.getElementById('edit_email_id').value = email;
        document.getElementById('edit_password').value = password;

        const imagePreview = document.getElementById('edit_image_preview');

        // show old image
        if (image) {
            imagePreview.src = "{{ asset('storage') }}/" + image;
            imagePreview.style.display = 'block';
        } else {
            imagePreview.src = '';
            imagePreview.style.display = 'none';
        }

        // clear file input
        document.getElementById('edit_image_input').value = '';
    }

    // This runs when a new file is selected
    document.addEventListener("DOMContentLoaded", function () {
        const fileInput = document.getElementById('edit_image_input');
        const preview = document.getElementById('edit_image_preview');

        fileInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        });
    });

    function deleteStudent(studentId) {

        alert("Are you sure you want to delete this student?");
        document.getElementById('delete_student_id').value = studentId;
        document.getElementById('delete-student-form').submit();
    }

</script>