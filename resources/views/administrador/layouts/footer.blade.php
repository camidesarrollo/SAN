<!-- /.modal pass-->

<div id="modalMsjConfirm" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <input type="hidden" value="" id="txtTipoMsj" />
            <div class="modal-header"><h4 class="modal-title" id="tituloMsjConfirm"></h4></div>
            <div class="modal-body" id="bodyMsjConfirm"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" data-loading-text="Guardando..." id="btnMsjConfirm">Aceptar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--Modal mensajes-->
<div id="modalMsj" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">Información</h4></div>
            <div class="modal-body" id="msjInfo"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@section('footer-top')
<div class="top">
    <div class="listas">
        <div class="lista">
            <h3></h3>
            <div>
                <ul  class="menu">
                    <li  class="menu-item"><a href="" target="_blank"><strong></strong></a></li>
                    <li  class="menu-item"><a href="" target="_blank"></a></li>
                    <li  class="menu-item"><a href="" target="_blank"></a></li>
                    <li  class="menu-item"><a href=""></a></li>
                    <li  class="menu-item"><a href="" target="_blank"></a></li>
                    <li  class="menu-item"><a href="" target="_blank"></a></li>
                </ul>
            </div>
        </div>
        <div class="lista">
            <h3></h3>
            <div>
                <ul  class="menu">
                    <li  class="menu-item"><a href="" target="_blank"></a></li>
                    <li  class="menu-item"><a href=""></a></li>
                    <li  class="menu-item"><a href="" target="_blank"></a></li>
                    <li  class="menu-item"><a href="" target="_blank"></a></li>
                    <li  class="menu-item"><a href=""></a></li>
                    <li  class="menu-item"><a href="" target="_blank"></a></li>
                </ul>
            </div>
        </div>
        <div class="lista">
            <h3></h3>
            <div>
                <ul  class="menu">
                    <li  class="menu-item"><a href="" target="_blank"></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cf"></div>
    <div class="sep"></div>
</div>
@stop

@section('footer-bottom')
<div class="bottom">
    <div class="left"><span>Ministerio de Desarrollo Social - Gobierno de Chile</span> </div>
    <?php /*
      <nav>
      <ul>
      <li><a href="">Políticas de Privacidad</a></li>
      <li><a href="">Visualizadores & Plug-ins</a></li>
      </ul>
      </nav>
     */ ?>
    <div class="cf"></div>
    <div class="bicolor"><span class="blue"></span><span class="red"></span></div>
</div>
@stop