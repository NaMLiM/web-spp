@extends('layouts.backend.app')
@section('title', 'Profil')
@section('content_title', 'Profil')
@section('content')
    <x-alert></x-alert>
    @role('admin|petugas')
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-header">
                        Profil
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Nama Petugas:</label>
                                    <input type="" name="" value="{{ Universe::petugas()->nama_petugas }}"
                                        readonly="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Kode Petugas:</label>
                                    <input type="" name="" value="{{ Universe::petugas()->kode_petugas }}"
                                        readonly="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Username Login:</label>
                                    <input type="" name="" value="{{ Auth::user()->username }}" readonly=""
                                        id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    @role('siswa')
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-header">
                        Profil
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="username">Nama Siswa:</label>
                                    <input type="" name="" value="{{ Universe::siswa()->nama_siswa }}"
                                        readonly="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="username">Kelas:</label>
                                    <input type="" name="" value="{{ Universe::siswa()->kelas->nama_kelas }}"
                                        readonly="" id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="username">NISN:</label>
                                    <input type="" name="" value="{{ Universe::siswa()->nisn }}" readonly=""
                                        id="" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="username">NIS:</label>
                                    <input type="" name="" value="{{ Universe::siswa()->nis }}" readonly=""
                                        id="" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endrole

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    Ubah Password Login
                </div>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="old_password">Password Sekarang:</label>
                            <input type="password" name="old_password" required="" id="old_password"
                                class="form-control">
                            @error('old_password')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">Password Baru:</label>
                            <input type="password" name="new_password" required="" id="new_password"
                                class="form-control">
                            @error('new_password')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save fa-fw"></i>
                                UBAH PASSWORD
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection
