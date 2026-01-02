<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-12">
                <h2><?php __('plugin_stripe_menu_payments') ?></h2>
            </div>
        </div><!-- /.row -->

        <!--<p class="m-b-none"><i class="fa fa-info-circle"></i><?php __('plugin_stripe_menu_payments') ?></p>-->
    </div><!-- /.col-md-12 -->
</div>

<div class="row wrapper wrapper-content animated fadeInRight">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row m-b-md">
                    <div class="col-md-4">
                        &nbsp;
                    </div><!-- /.col-md-6 -->

                    <div class="col-md-4 col-sm-8">
                        <form action="" method="get" class="form-horizontal frm-filter" autocomplete="off">
                            <div class="input-group">
                                <input type="text" name="q" placeholder="<?php __('plugin_base_btn_search', false, true); ?>" class="form-control">
                                <div class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.col-md-3 -->
                </div><!-- /.row -->

                <div id="grid"></div>
            </div>
        </div>
    </div><!-- /.col-lg-12 -->
</div>

<div class="modal fade" id="modalStripeInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close"
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only"><?php __('plugin_base_btn_close') ?></span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php __('plugin_stripe_info_title') ?></h4>
            </div>

            <!-- Modal Body -->
            <div class="modal-body"></div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php __('plugin_base_btn_close') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var myLabel = myLabel || {};
myLabel.foreign_id = <?php echo pjAppController::jsonEncode(__('plugin_stripe_foreign_id', true)); ?>;
myLabel.stripe_id = <?php echo pjAppController::jsonEncode(__('plugin_stripe_stripe_id', true)); ?>;
myLabel.token = <?php echo pjAppController::jsonEncode(__('plugin_stripe_token', true)); ?>;
myLabel.amount = <?php echo pjAppController::jsonEncode(__('plugin_stripe_amount', true)); ?>;
myLabel.currency = <?php echo pjAppController::jsonEncode(__('plugin_stripe_currency', true)); ?>;
myLabel.created = <?php echo pjAppController::jsonEncode(__('plugin_stripe_created', true)); ?>;
myLabel.btn_view = <?php echo pjAppController::jsonEncode(__('plugin_stripe_btn_view', true)); ?>;
myLabel.btn_close = <?php echo pjAppController::jsonEncode(__('plugin_stripe_btn_close', true)); ?>;
</script>