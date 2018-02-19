<div class="modal-info-table" style="display:none;">
    <div class="modal-info-body">
        <span class="close-modal-info"><i class="fa fa-times" aria-hidden="true"></i></span>
        <div class="modal-info-desc">
            <h3 class="title-info"></h3>
            <div class="desc-modal-info">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 assignees"></div>
                    <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                        <p class="start-from">
                            <span>Due:</span> <strong class="due-card-here"></strong>
                            <span class="button-grouppp">
                                <a href="#" class="button-default" id="siteUrl" target="_blank">Site</a>
                                <a href="#" class="button-default" id="cardUrl" target="_blank">Card</a>
                            </span>
                        </p>
                    </div>
                    <div class="fields"></div>
                    <div id="anexos-bloco" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p class="start-from block-p">
                            <span>Anexos</span>
                            <div class="row attachments"></div>
                        </p>
                    </div>
                    <div id="descricao-bloco" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p class="start-from descr"><span>Descrição:</span> <strong class="description"></strong></p>
                    </div>
                </div>
                <div class="row timeline-row" style="display: none;">
                    <span class="title-row">Timeline</span>
                    <ul class="timeline"></ul>
                </div>
                <div id="bloco-comentarios" class="row">
                    <div class="comments">
                    </div>
                    <div class="input-comment" style="display: none;">
                        <form action="{{ route('api.cards.comment') }}" method="post">
                            <div class="form-group">
                                <label for="comment" class="title-row">Comentar:</label>
                                <textarea name="comment" id="comment" rows="5" class="form-control"></textarea>
                                <input type="hidden" name="card_id">
                                {{ csrf_field() }}
                            </div>
                            <button class="btn btn-primary pull-right" type="submit"><i class="fa fa-comment"></i> Comentar</button>
                        </form>
                    </div>
                </div>
                <div class="buttonsModal">
                    <a href="javascript:void(0)" class="show-timeline buttonP">Ver Timeline</a>
                    <a href="javascript:void(0)" class="show-comments buttonP">Ver Comentários</a>
                </div>
            </div>
        </div>
    </div>
</div>