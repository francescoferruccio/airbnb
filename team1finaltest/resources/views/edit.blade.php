@extends('layouts.app')

{{-- PAGINA MODIFICA APPARTAMENTO --}}
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Modifica il tuo appartamento') }}</div>

          {{-- FORM PER MODIFICA APPARTAMENTO --}}
          <div class="card-body">
            <form method="POST" action="{{ route('update', $apartment -> id) }}" enctype="multipart/form-data" role="form">
              @csrf
              @method('POST')
              {{-- NOME APPARTAMENTO --}}
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $apartment['name'] }}" autocomplete="name" autofocus>

                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                </div>
                {{-- DESCRIZIONE APPARTAMENTO --}}
                <div class="form-group row">
                  <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Descrizione') }}</label>

                  <div class="col-md-6">
                    <textarea id="description" rows="4" cols="50" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" autofocus>{{ $apartment['description'] }}</textarea>

                      @error('description')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  {{-- NUMERO STANZE APPARTAMENTO --}}
                  <div class="form-group row">
                    <label for="rooms" class="col-md-4 col-form-label text-md-right">{{ __('Stanze') }}</label>

                    <div class="col-md-6">
                      <input id="rooms" min="1" type="number" class="form-control @error('rooms') is-invalid @enderror" name="rooms" value="{{ $apartment['rooms'] }}" autocomplete="rooms" autofocus>

                        @error('rooms')
                          <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                          </span>
                        @enderror
                      </div>
                    </div>
                    {{-- NUMERO LETTI APPARTAMENTO --}}
                    <div class="form-group row">
                      <label for="beds" class="col-md-4 col-form-label text-md-right">{{ __('Letti') }}</label>

                      <div class="col-md-6">
                        <input id="beds" min="1" type="number" class="form-control @error('beds') is-invalid @enderror" name="beds" value="{{ $apartment['beds'] }}" autocomplete="beds" autofocus>

                          @error('beds')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                      {{-- NUMERO BAGNI APPARTAMENTO --}}
                      <div class="form-group row">
                        <label for="bathrooms" class="col-md-4 col-form-label text-md-right">{{ __('Bagni') }}</label>

                        <div class="col-md-6">
                          <input id="bathrooms" min="1" type="number" class="form-control @error('bathrooms') is-invalid @enderror" name="bathrooms" value="{{ $apartment['bathrooms'] }}" autocomplete="bathrooms" autofocus>

                            @error('bathrooms')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                            @enderror
                          </div>
                        </div>
                        {{-- SUPERFICIE APPARTAMENTO --}}
                        <div class="form-group row">
                          <label for="size" class="col-md-4 col-form-label text-md-right">{{ __('Superficie(mq)') }}</label>

                          <div class="col-md-6">
                            <input id="size" min="1" type="number" class="form-control @error('size') is-invalid @enderror" name="size" value="{{ $apartment['size'] }}" autocomplete="size" autofocus>

                              @error('size')
                                <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          {{-- INDIRIZZO APPARTAMENTO --}}
                          <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo') }}</label>

                            <div class="col-md-6">
                              <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $apartment['address'] }}" required autocomplete="address">

                                @error('address')
                                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                              </div>
                            </div>
                            {{-- IMMAGINE APPARTAMENTO --}}
                            <div class="form-group row">
                              <label for="picture" class="col-md-4 col-form-label text-md-right">{{ __('Immagine') }}</label>

                              <div class="col-md-6">
                                <input type="hidden" name="MAX_FILE_SIZE" value="50971520" />
                                <input id="picture" type="file" accept="image/x-png,image/gif,image/jpeg" class="form-control @error('picture') is-invalid @enderror" name="picture" autocomplete="new-picture">

                                  @error('picture')
                                    <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                    </span>
                                  @enderror
                                </div>
                              </div>
                              {{-- SERVIZI APPARTAMENTO --}}
                              <div class="form-group row">
                                <div class="col-md-12">
                                  <label for="services[]" class="col-md-4 col-form-label text-md-right">{{ __('Servizi:') }}</label>
                                </div>
                                @foreach ($services as $service)
                                  <div class="col-md-10">
                                    <div class="d-flex justify-content-center">
                                      <div class="col-md-4">
                                        <input id="service" type="checkbox" @error('services[]') is-invalid @enderror name="services[]" autocomplete="new-service_id" value ="{{$service['id']}}"
                                        @foreach ($apartment->services as $aptService)
                                          @if ($service['id'] == $aptService['id'])
                                            checked
                                          @endif
                                        @endforeach
                                        >
                                          {{$service -> name}}
                                        </div>
                                      </div>

                                      @error('services[]')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror

                                    </div>
                                  @endforeach
                                </div>
                                <div class="form-group row">
                                  <label for="show" class="col-md-4 col-form-label text-md-right">{{ __('Vuoi rendere il tuo annuncio visibile?') }}</label>

                                  <div class="col-md-6">
                                    <div class="d-flex justify-content-start">
                                      <label for="0">NO</label>
                                      <input id="show" type="radio" class="form-control @error('picture') is-invalid @enderror" name="show" value="0" autocomplete="new-picture">
                                    </div>
                                    <div class="d-flex justify-content-start">
                                      <label for="1">SI</label>
                                      <input id="show" type="radio" class="form-control @error('picture') is-invalid @enderror" name="show" value="1" autocomplete="new-picture">
                                    </div>
                                      @error('picture')
                                        <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                        </span>
                                      @enderror
                                    </div>
                                  </div>
                                {{-- SUBMIT --}}
                                <div class="form-group row mb-0">
                                  <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                      {{ __('Modifica') }}
                                    </button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endsection
