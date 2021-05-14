<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $teacher_info->name }}</h3>
    </div>
    <div class="card-body">
        <strong><i class="fas fa-book mr-1"></i> Bộ môn: </strong>

        <p class="text-muted" style="display: inline">{{ $teacher_info->department->name }}</p>

        <hr>

        <strong><i class="fas fa-align-justify mr-1"></i> Học vị: </strong>

        <p class="text-muted" style="display: inline">{{ $teacher_info->degree }}</p>

        <hr>

        <strong><i class="fas fa-envelope mr-1"></i> Email: </strong>

        <p class="text-muted" style="display: inline">{{ $teacher_info->email }}</p>

        <hr>

        <strong><i class="fas fa-phone-alt mr-1"></i> Điện thoại: </strong>

        <p class="text-muted" style="display: inline">{{ $teacher_info->phone }}</p>

    </div>
</div>