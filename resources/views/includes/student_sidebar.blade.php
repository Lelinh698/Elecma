<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $student_info->name }}</h3>
    </div>
    <div class="card-body">
        <strong><i class="fas fa-book mr-1"></i> Mã số: </strong>

        <p class="text-muted" style="display: inline">{{ $student_info->mssv }}</p>

        <hr>

        <strong><i class="fas fa-align-justify mr-1"></i> Khoá: </strong>

        <p class="text-muted" style="display: inline">{{ $student_info->year }}</p>

        <hr>

        <strong><i class="fas fa-envelope mr-1"></i> Email: </strong>

        <p class="text-muted" style="display: inline">{{ $student_info->email }}</p>

        <hr>

        <strong><i class="fas fa-phone-alt mr-1"></i> Điện thoại: </strong>

        <p class="text-muted" style="display: inline">{{ $student_info->phone }}</p>

    </div>
</div>