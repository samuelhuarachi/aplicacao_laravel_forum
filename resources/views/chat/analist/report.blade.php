@extends('chat.analist.base')

@section('content')

<div class="container mt-3">
    <div class="row">
        <div class="col-md-12 mb-3">
            <h1 class="mb-4">Relatório</h1>
            <form>
                Ano
                <select name="year" id="year">
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                </select>

                Mês
                <select name="mounth" id="mounth">
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Decembro</option>
                </select>

                <button type="submit" class="btn btn-primary">Ver Ganhos</button>
            </form>
        </div>
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <h2>Ganhos em Sessões Privadas</h2>

                    <div class="accordion mt-3" id="seePrivate">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseOneSeePrivate"
                                        aria-controls="collapseOneSeePrivate">
                                        Visualizar <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOneSeePrivate" class="collapse " aria-labelledby="headingOne"
                                data-parent="#seePrivate">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            @if($report && json_decode($report)->formatedResponse)
                                            @foreach(array_reverse(json_decode($report)->formatedResponse) as $r)
                                            <tr>
                                                <td scope="row">
                                                    <b>Tempo Total</b> {{ $r->longTimeFormat }} <br>
                                                    <b>Inicio</b> {{ $r->startFormated }} <br>
                                                    <b>Fim</b> {{ $r->endFormated }} <br>

                                                    <br><br>
                                                    <b>Ganhos</b> {{ $r->analistGains }}
                                                    <b>Site</b> {{ $r->systemGain }}
                                                    <b>Total</b> {{ $r->clientDebit }}
                                                </td>
                                                <td>
                                                    <b>Cliente</b> {{ $r->clientNickname }} <br>
                                                    <b>Valor Hora</b> {{ $r->pricePerHour }}
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <p>Nenhum dado encontrado</p>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="col-md-12 mb-3">

            <div class="card">
                <div class="card-body">
                    <h2>Ganhos em Propostas</h2>

                    <div class="accordion mt-3" id="accordionProposeGains">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseOnePropose"
                                        aria-controls="collapseOnePropose">
                                        Visualizar <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOnePropose" class="collapse " aria-labelledby="headingOne"
                                data-parent="#accordionProposeGains">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            @php
                                            $contador1 = 0
                                            @endphp

                                            @if(json_decode($report) && json_decode($report)->challengeData)
                                            @foreach(array_reverse(json_decode($report)->challengeData) as $r)
                                            @php
                                            $contador1 = $contador1 + 1
                                            @endphp
                                            <tr>
                                                <td scope="row">
                                                    @if($r->status == -1)
                                                    <span class="badge badge-danger">cacelado</span>
                                                    @elseif($r->status == 1)
                                                    <span class="badge badge-primary">coletado</span>
                                                    @elseif ($r->status == 2)
                                                    <span class="badge badge-success">finalizado</span>
                                                    @endif
                                                    <b>Titulo</b> {{ $r->do1 }}
                                                    <b>Ganhos</b> {{ $r->price }} - {{ $r->created_atFormated }}
                                                    <br>

                                                    @if($r->status !== -1)
                                                    <div class="accordion mt-3" id="accordionExample">
                                                        <div class="card">
                                                            <div class="card-header" id="headingOne">
                                                                <h2 class="mb-0">
                                                                    <button class="btn btn-link btn-block text-left"
                                                                        type="button" data-toggle="collapse"
                                                                        data-target="#collapseOne{{ $contador1 }}"
                                                                        aria-controls="collapseOne{{ $contador1 }}">
                                                                        Lista dos clientes que enviaram <i
                                                                            class="fas fa-caret-down"></i>
                                                                    </button>
                                                                </h2>
                                                            </div>

                                                            <div id="collapseOne{{ $contador1 }}" class="collapse "
                                                                aria-labelledby="headingOne"
                                                                data-parent="#accordionExample">
                                                                <div class="card-body">
                                                                    @foreach($r->donationsData as $donation)
                                                                    <b>Cliente</b> {{ $donation->clientNickName }}
                                                                    no dia {{ $donation->created_atFormated }} enviou
                                                                    {{ $donation->price }}<br>
                                                                    <br>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <br>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <p>Nenhum dado encontrado</p>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2>Ganhos Avulso</h2>


                    <div class="accordion mt-3" id="accordionStandAlone">
                        <div class="card">
                            <div class="card-header" id="headingOneStandAlone">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseStandAlone"
                                        aria-controls="collapseStandAlone">
                                        Visualizar <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseStandAlone" class="collapse " aria-labelledby="headingOneStandAlone"
                                data-parent="#accordionStandAlone">
                                <div class="card-body">
                                    <table class="table">
                                        <tbody>
                                            @if($report && json_decode($report)->giftData)
                                                @foreach(array_reverse(json_decode($report)->giftData) as $r)
                                                <tr>
                                                    <td scope="row">

                                                        <b>Cliente</b> {{ $r->clientNickName }}
                                                        <b>Enviou</b> {{ $r->value }} - {{ $r->createds_atFormated }}
                                                        <br>

                                                        <br>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <p>Nenhum dado encontrado</p>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <footer class="mb-5"></footer>
    </div>
</div>

<style>
    h2,
    h3,
    h4,
    h5 {
        font-family: "Arsenal";
    }

</style>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


@endsection
