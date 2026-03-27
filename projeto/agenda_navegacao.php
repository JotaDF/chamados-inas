<div class="col-auto">
    <button class="btn btn-outline-primary btn-sm d-flex align-items-center px-3" id="btnAnterior"
        onclick="proximoDia('<?= $hoje ?>')">
        <i class="fa fa-chevron-left mr-2"></i> Anterior
    </button>
</div>
<div class="col-md text-center">
    <div class="px-4 py-2 bg-light rounded shadow-sm d-inline-block">
        <h5 class="mb-0 text-primary fw-bold">
            <i class="fa fa-calendar-day mr-1"></i>
            <span id="diaAtual"></span>
        </h5>
        <small class="text-muted d-block" id="diaSemana">
        </small>
    </div>
</div>
<div class="col-auto">
    <button class="btn btn-outline-primary btn-sm d-flex align-items-center px-3" id="btnProximo"
        onclick="proximoDia()">
        Próximos <i class="fa fa-chevron-right ml-2"></i>
        <span id="dataProximo" class="badge badge-primary ml-2"></span>
    </button>
</div>
<div class="col-auto">
    <button class="btn btn-outline-success btn-sm d-flex align-items-center px-3" onclick="proximoDia('<?= $hoje ?>')">
        <i class="fa fa-undo mr-2"></i> Hoje
    </button>
</div>
<div class="col-auto">
    <div class="dropdown">
        <button class="btn btn-outline-primary btn-sm dropdown-toggle px-3" id="dropdownDatas" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Selecionar data
            <div class="dropdown-menu dropdown-scroll" id="agenda"></div>
        </button>
    </div>
</div>