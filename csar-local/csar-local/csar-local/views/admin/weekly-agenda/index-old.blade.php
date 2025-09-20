@extends('layouts.admin')

@section('title', 'Agenda Hebdomadaire - CSAR')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Agenda Hebdomadaire</h1>
            <p class="text-muted">Gestion des événements et instructions de la semaine</p>
        </div>
        <div>
            <a href="{{ route('admin.weekly-agenda.calendar') }}" class="btn btn-info mr-2">
                <i class="fas fa-calendar-alt"></i> Vue Calendrier
            </a>
            <a href="{{ route('admin.weekly-agenda.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvel Événement
            </a>
        </div>
    </div>

    <!-- Week Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $weekTitle }}</h5>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.weekly-agenda.index', ['week' => 'current']) }}" 
                               class="btn btn-{{ $week == 'current' ? 'primary' : 'outline-primary' }}">
                                Cette semaine
                            </a>
                            <a href="{{ route('admin.weekly-agenda.index', ['week' => 'next']) }}" 
                               class="btn btn-{{ $week == 'next' ? 'primary' : 'outline-primary' }}">
                                Semaine prochaine
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Réunions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['meetings'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Livraisons</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['deliveries'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Visites</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['visits'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Tâches</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['tasks'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Instructions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['instructions'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Schedule -->
    <div class="row">
        @php
            $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            $dayColors = ['primary', 'info', 'warning', 'success', 'danger', 'secondary', 'dark'];
        @endphp
        
        @foreach($days as $index => $day)
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3 bg-{{ $dayColors[$index] }} text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-calendar-day"></i> {{ $day }}
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $dayEvents = $agenda->filter(function($event) use ($index) {
                                return $event->start_date->dayOfWeek == ($index + 1);
                            });
                        @endphp
                        
                        @if($dayEvents->count() > 0)
                            <div class="row">
                                @foreach($dayEvents as $event)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card border-left-{{ $event->priority == 'urgent' ? 'danger' : ($event->priority == 'high' ? 'warning' : 'info') }}">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title mb-0">{{ $event->title }}</h6>
                                                    <span class="badge badge-{{ $event->priority == 'urgent' ? 'danger' : ($event->priority == 'high' ? 'warning' : 'info') }}">
                                                        {{ ucfirst($event->priority) }}
                                                    </span>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock"></i> 
                                                        {{ $event->start_date->format('H:i') }}
                                                        @if($event->end_date)
                                                            - {{ $event->end_date->format('H:i') }}
                                                        @endif
                                                    </small>
                                                </div>
                                                
                                                @if($event->location)
                                                    <div class="mb-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                                                        </small>
                                                    </div>
                                                @endif
                                                
                                                @if($event->description)
                                                    <p class="card-text small text-muted">{{ Str::limit($event->description, 80) }}</p>
                                                @endif
                                                
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        @if($event->assignedTo)
                                                            <i class="fas fa-user"></i> {{ $event->assignedTo->name }}
                                                        @else
                                                            <i class="fas fa-user-slash"></i> Non assigné
                                                        @endif
                                                    </small>
                                                    <span class="badge badge-{{ $event->status == 'completed' ? 'success' : ($event->status == 'in_progress' ? 'info' : 'secondary') }}">
                                                        {{ ucfirst($event->status) }}
                                                    </span>
                                                </div>
                                                
                                                <div class="mt-2">
                                                    <div class="btn-group btn-group-sm w-100" role="group">
                                                        <button type="button" class="btn btn-outline-info btn-sm" onclick="viewEvent({{ $event->id }})">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="editEvent({{ $event->id }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        @if($event->status == 'scheduled')
                                                            <button type="button" class="btn btn-outline-success btn-sm" onclick="startEvent({{ $event->id }})">
                                                                <i class="fas fa-play"></i>
                                                            </button>
                                                        @elseif($event->status == 'in_progress')
                                                            <button type="button" class="btn btn-outline-success btn-sm" onclick="completeEvent({{ $event->id }})">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">Aucun événement prévu pour {{ $day }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de l'Événement</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="eventModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewEvent(eventId) {
    $.get(`/admin/weekly-agenda/${eventId}`, function(data) {
        $('#eventModalBody').html(data);
        $('#eventModal').modal('show');
    });
}

function editEvent(eventId) {
    window.location.href = `/admin/weekly-agenda/${eventId}/edit`;
}

function startEvent(eventId) {
    updateEventStatus(eventId, 'in_progress');
}

function completeEvent(eventId) {
    updateEventStatus(eventId, 'completed');
}

function updateEventStatus(eventId, status) {
    $.ajax({
        url: `/admin/weekly-agenda/${eventId}/update-status`,
        method: 'PATCH',
        data: {
            status: status,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function() {
            alert('Erreur lors de la mise à jour du statut');
        }
    });
}
</script>
@endpush 

@section('title', 'Agenda Hebdomadaire - CSAR')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Agenda Hebdomadaire</h1>
            <p class="text-muted">Gestion des événements et instructions de la semaine</p>
        </div>
        <div>
            <a href="{{ route('admin.weekly-agenda.calendar') }}" class="btn btn-info mr-2">
                <i class="fas fa-calendar-alt"></i> Vue Calendrier
            </a>
            <a href="{{ route('admin.weekly-agenda.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nouvel Événement
            </a>
        </div>
    </div>

    <!-- Week Navigation -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $weekTitle }}</h5>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.weekly-agenda.index', ['week' => 'current']) }}" 
                               class="btn btn-{{ $week == 'current' ? 'primary' : 'outline-primary' }}">
                                Cette semaine
                            </a>
                            <a href="{{ route('admin.weekly-agenda.index', ['week' => 'next']) }}" 
                               class="btn btn-{{ $week == 'next' ? 'primary' : 'outline-primary' }}">
                                Semaine prochaine
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Réunions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['meetings'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Livraisons</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['deliveries'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Visites</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['visits'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Tâches</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['tasks'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Instructions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['instructions'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Schedule -->
    <div class="row">
        @php
            $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
            $dayColors = ['primary', 'info', 'warning', 'success', 'danger', 'secondary', 'dark'];
        @endphp
        
        @foreach($days as $index => $day)
            <div class="col-lg-12 mb-4">
                <div class="card shadow">
                    <div class="card-header py-3 bg-{{ $dayColors[$index] }} text-white">
                        <h6 class="m-0 font-weight-bold">
                            <i class="fas fa-calendar-day"></i> {{ $day }}
                        </h6>
                    </div>
                    <div class="card-body">
                        @php
                            $dayEvents = $agenda->filter(function($event) use ($index) {
                                return $event->start_date->dayOfWeek == ($index + 1);
                            });
                        @endphp
                        
                        @if($dayEvents->count() > 0)
                            <div class="row">
                                @foreach($dayEvents as $event)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card border-left-{{ $event->priority == 'urgent' ? 'danger' : ($event->priority == 'high' ? 'warning' : 'info') }}">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="card-title mb-0">{{ $event->title }}</h6>
                                                    <span class="badge badge-{{ $event->priority == 'urgent' ? 'danger' : ($event->priority == 'high' ? 'warning' : 'info') }}">
                                                        {{ ucfirst($event->priority) }}
                                                    </span>
                                                </div>
                                                
                                                <div class="mb-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock"></i> 
                                                        {{ $event->start_date->format('H:i') }}
                                                        @if($event->end_date)
                                                            - {{ $event->end_date->format('H:i') }}
                                                        @endif
                                                    </small>
                                                </div>
                                                
                                                @if($event->location)
                                                    <div class="mb-2">
                                                        <small class="text-muted">
                                                            <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                                                        </small>
                                                    </div>
                                                @endif
                                                
                                                @if($event->description)
                                                    <p class="card-text small text-muted">{{ Str::limit($event->description, 80) }}</p>
                                                @endif
                                                
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        @if($event->assignedTo)
                                                            <i class="fas fa-user"></i> {{ $event->assignedTo->name }}
                                                        @else
                                                            <i class="fas fa-user-slash"></i> Non assigné
                                                        @endif
                                                    </small>
                                                    <span class="badge badge-{{ $event->status == 'completed' ? 'success' : ($event->status == 'in_progress' ? 'info' : 'secondary') }}">
                                                        {{ ucfirst($event->status) }}
                                                    </span>
                                                </div>
                                                
                                                <div class="mt-2">
                                                    <div class="btn-group btn-group-sm w-100" role="group">
                                                        <button type="button" class="btn btn-outline-info btn-sm" onclick="viewEvent({{ $event->id }})">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="editEvent({{ $event->id }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        @if($event->status == 'scheduled')
                                                            <button type="button" class="btn btn-outline-success btn-sm" onclick="startEvent({{ $event->id }})">
                                                                <i class="fas fa-play"></i>
                                                            </button>
                                                        @elseif($event->status == 'in_progress')
                                                            <button type="button" class="btn btn-outline-success btn-sm" onclick="completeEvent({{ $event->id }})">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">Aucun événement prévu pour {{ $day }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de l'Événement</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="eventModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewEvent(eventId) {
    $.get(`/admin/weekly-agenda/${eventId}`, function(data) {
        $('#eventModalBody').html(data);
        $('#eventModal').modal('show');
    });
}

function editEvent(eventId) {
    window.location.href = `/admin/weekly-agenda/${eventId}/edit`;
}

function startEvent(eventId) {
    updateEventStatus(eventId, 'in_progress');
}

function completeEvent(eventId) {
    updateEventStatus(eventId, 'completed');
}

function updateEventStatus(eventId, status) {
    $.ajax({
        url: `/admin/weekly-agenda/${eventId}/update-status`,
        method: 'PATCH',
        data: {
            status: status,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                location.reload();
            }
        },
        error: function() {
            alert('Erreur lors de la mise à jour du statut');
        }
    });
}
</script>
@endpush 
 
 
 
 
 
 