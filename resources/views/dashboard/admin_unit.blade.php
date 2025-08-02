@extends('layouts.app')
@section('titlepage', 'Dashboard')
@section('content')
    <style>
        .dashboard-header {
            background: linear-gradient(120deg, #1B5E20 60%, #388e3c 100%);
            border-radius: 1.2rem;
            padding: 1.5rem 2rem 1.2rem 2rem;
            margin-bottom: 1.5rem;
            color: #fff;
            box-shadow: 0 4px 16px 0 rgba(27, 94, 32, 0.10);
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .dashboard-header .avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(27, 94, 32, 0.10);
        }

        .dashboard-header .welcome {
            font-size: 1.7rem;
            font-weight: 700;
            margin-bottom: 0.1rem;
            color: #fff;
        }

        .dashboard-header .desc {
            font-size: 1rem;
            color: #b9f6ca;
            opacity: 1;
        }

        @media (max-width: 600px) {
            .dashboard-header {
                padding: 1rem 0.7rem 0.8rem 0.7rem;
                gap: 0.7rem;
            }

            .dashboard-header .avatar {
                width: 38px;
                height: 38px;
            }

            .dashboard-header .welcome {
                font-size: 1.1rem;
            }

            .dashboard-header .desc {
                font-size: 0.85rem;
            }
        }
    </style>
    <div class="dashboard-header">
        <img src="{{ asset(auth()->user()->avatar ? 'storage/avatars/' . auth()->user()->avatar : 'assets/img/avatars/1.png') }}"
            class="avatar" alt="Avatar">
        <div>
            <div class="welcome">Selamat Datang, {{ auth()->user()->name }}</div>
            <div class="desc">Semoga harimu menyenangkan dan produktif!</div>
        </div>
    </div>
@endsection
