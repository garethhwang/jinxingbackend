<?php echo $header; ?>
<div class="container">
    <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
    </ul>
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
    <?php } ?>
    <div class="row"><?php echo $column_left; ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-sm-6'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-sm-9'; ?>
        <?php } else { ?>
        <?php $class = 'col-sm-12'; ?>
        <?php } ?>
        <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
            <h1><?php echo $heading_title; ?></h1>

            <p><?php echo $text_account_already; ?></p>

            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">

                <fieldset id="account">
                    <legend><?php echo $text_your_details; ?></legend>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-2 control-label" for="input-wechat_id">微信信息</label>

                        <div class="col-sm-10">
                            <input type="text" name="wechat_id" value="<?php echo $wechat_id; ?>" placeholder="微信"
                                   id="input-wechat_id" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group required" style="display: <?php echo (count($customer_groups) > 1 ? 'block' : 'none'); ?>;">
                        <label class="col-sm-2 control-label"><?php echo $entry_customer_group; ?></label>

                        <div class="col-sm-10">
                            <?php foreach ($customer_groups as $customer_group) { ?>
                            <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="customer_group_id"
                                           value="<?php echo $customer_group['customer_group_id']; ?>"
                                           checked="checked"/>
                                    <?php echo $customer_group['name']; ?></label>
                            </div>
                            <?php } else { ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="customer_group_id"
                                           value="<?php echo $customer_group['customer_group_id']; ?>"/>
                                    <?php echo $customer_group['name']; ?></label>
                            </div>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label"
                               for="input-realname"><?php echo $entry_realname; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="realname" value="<?php echo $realname; ?>"
                                   placeholder="<?php echo $entry_realname; ?>" id="input-realname"
                                   class="form-control"/>
                            <?php if ($error_realname) { ?>
                            <div class="text-danger"><?php echo $error_realname; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <!--div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-email"></label>
                        <div class="col-sm-10">
                            <input type="email" name="email"  id="input-email" class="form-control"/>
                        </div>
                    </div-->
                    <div class="form-group required">
                        <label class="col-sm-2 control-label"
                               for="input-telephone"><?php echo $entry_telephone; ?></label>
                        <div class="col-sm-10">
                            <input type="tel" name="telephone" value="<?php echo $telephone; ?>"
                                   placeholder="<?php echo $entry_telephone; ?>" id="input-telephone"
                                   class="form-control"/>
                            <?php if ($error_telephone) { ?>
                            <div class="text-danger"><?php echo $error_telephone; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-barcode"><?php echo $entry_barcode; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="barcode" value="<?php echo $barcode; ?>"
                                   placeholder="<?php echo $entry_barcode; ?>" id="input-barcode" class="form-control"/>
                            <?php if ($error_barcode) { ?>
                            <div class="text-danger"><?php echo $error_barcode; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label"
                               for="input-birthday"><?php echo $entry_birthday; ?></label>
                        <div class="col-sm-10">
                            <input type="date" name="birthday" value="<?php echo $birthday; ?>"
                                   placeholder="<?php echo $entry_birthday; ?>" id="input-birthday"
                                   class="form-control"/>
                            <?php if ($error_birthday) { ?>
                            <div class="text-danger"><?php echo $error_birthday; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label"
                               for="input-department"><?php echo $entry_department; ?></label>

                        <div class="col-sm-10">

                            <select name="department" id="input-department" class="form-control">
                                <?php foreach ($departmentlist as $dep) { ?>
                            <?php if($dep["office_id"]==$department){ ?>
                            <option value="<?php echo $dep['office_id']; ?>" selected><?php echo $dep["name"]; ?></option>
                            <?php } else { ?>
                            <option value="<?php echo $dep['office_id']; ?>"><?php echo $dep["name"]; ?></option>
                            <?php } ?>
                            <?php } ?>
                            </select>
                            <?php if ($error_department) { ?>
                            <div class="text-danger"><?php echo $error_department; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label"
                               for="pregnantstatus"><?php echo $entry_pregnantstatus; ?></label>

                        <div class="col-sm-10">
                            <select name="pregnantstatus" id="pregnantstatus" class="form-control">
                                <?php if ($pregnantstatus=="0") { ?>
                                <option value="0" selected>未怀孕</option>
                                <?php } else{ ?>
                                <option value="0">未怀孕</option>
                                <?php }?>
                                <?php if ($pregnantstatus=="1") { ?>
                                <option value="1" selected>怀孕中</option>
                                <?php } else{ ?>
                                <option value="1">怀孕中</option>
                                <?php }?>
                                <?php if ($pregnantstatus=="2") { ?>
                                <option value="2" selected>已生产</option>
                                <?php } else{ ?>
                                <option value="2">已生产</option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'account') { ?>
                    <?php if ($custom_field['type'] == 'select') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <select name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                    id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                    class="form-control">
                                <option value=""><?php echo $text_select; ?></option>
                                <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                                <?php if (isset($register_custom_field[$custom_field['custom_field_id']]) && $custom_field_value['custom_field_value_id'] == $register_custom_field[$custom_field['custom_field_id']]) { ?>
                                <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"
                                        selected="selected"><?php echo $custom_field_value['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'radio') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <div>
                                <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                                <div class="radio">
                                    <?php if (isset($register_custom_field[$custom_field['custom_field_id']]) && $custom_field_value['custom_field_value_id'] == $register_custom_field[$custom_field['custom_field_id']]) { ?>
                                    <label>
                                        <input type="radio"
                                               name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                               value="<?php echo $custom_field_value['custom_field_value_id']; ?>"
                                               checked="checked"/>
                                        <?php echo $custom_field_value['name']; ?></label>
                                    <?php } else { ?>
                                    <label>
                                        <input type="radio"
                                               name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                               value="<?php echo $custom_field_value['custom_field_value_id']; ?>"/>
                                        <?php echo $custom_field_value['name']; ?></label>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'checkbox') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <div>
                                <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                                <div class="checkbox">
                                    <?php if (isset($register_custom_field[$custom_field['custom_field_id']]) && in_array($custom_field_value['custom_field_value_id'], $register_custom_field[$custom_field['custom_field_id']])) { ?>
                                    <label>
                                        <input type="checkbox"
                                               name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]"
                                               value="<?php echo $custom_field_value['custom_field_value_id']; ?>"
                                               checked="checked"/>
                                        <?php echo $custom_field_value['name']; ?></label>
                                    <?php } else { ?>
                                    <label>
                                        <input type="checkbox"
                                               name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]"
                                               value="<?php echo $custom_field_value['custom_field_value_id']; ?>"/>
                                        <?php echo $custom_field_value['name']; ?></label>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <input type="text"
                                   name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                   value="<?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>"
                                   placeholder="<?php echo $custom_field['name']; ?>"
                                   id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                   class="form-control"/>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'textarea') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <textarea
                                    name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                    rows="5" placeholder="<?php echo $custom_field['name']; ?>"
                                    id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                    class="form-control"><?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?></textarea>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'file') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <button type="button"
                                    id="button-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                    data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i
                                        class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                            <input type="hidden"
                                   name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                   value="<?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : ''); ?>"/>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'date') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <div class="input-group date">
                                <input type="date"
                                       name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                       value="<?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>"
                                       placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD"
                                       id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                       class="form-control"/>
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'time') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <div class="input-group time">
                                <input type="text"
                                       name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                       value="<?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>"
                                       placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm"
                                       id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                       class="form-control"/>
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'datetime') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <div class="input-group datetime">
                                <input type="text"
                                       name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                       value="<?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>"
                                       placeholder="<?php echo $custom_field['name']; ?>"
                                       data-date-format="YYYY-MM-DD HH:mm"
                                       id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                       class="form-control"/>
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </fieldset>
                <fieldset id="physical">
                    <legend><?php echo $text_your_physical; ?></legend>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="height" value="<?php echo $height; ?>"
                                   placeholder="<?php echo $entry_height; ?>" id="input-height"  class="form-control"/>
                            <?php if ($error_height) { ?>
                            <div class="text-danger"><?php echo $error_height; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-weight"><?php echo $entry_weight; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="weight" value="<?php echo $weight; ?>" onkeyup="countindex()"
                                   placeholder="<?php echo $entry_weight; ?>" id="input-weight" class="form-control"/>
                            <?php if ($error_weight) { ?>
                            <div class="text-danger"><?php echo $error_weight; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-bmiindex" ><?php echo $entry_bmiindex; ?></label>
                        <div class="col-sm-10">
                            <label name="bmiindex"  id="input-bmiindex" class=form-control"></label>
                            <?php if ($error_bmiindex) { ?>
                            <div class="text-danger"><?php echo $error_bmiindex; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-bmitype" ><?php echo $entry_bmitype; ?></label>
                        <div class="col-sm-10">
                            <label name="bmitype"  id="input-bmitype"  class="form-control"></label>
                            <?php if ($error_bmitype) { ?>
                            <div class="text-danger"><?php echo $error_bmitype; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-lastmenstrualdate"><?php echo $entry_lastmenstrualdate; ?></label>
                        <div class="col-sm-10">
                            <input type="date" name="lastmenstrualdate" value="<?php echo $lastmenstrualdate; ?>"
                                   placeholder="<?php echo $entry_lastmenstrualdate; ?>" id="input-lastmenstrualdate" class="form-control"/>
                            <?php if ($error_lastmenstrualdate) { ?>
                            <div class="text-danger"><?php echo $error_lastmenstrualdate; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-edc"><?php echo $entry_edc; ?></label>
                        <div class="col-sm-10">
                            <input type="date" name="edc" value="<?php echo $edc; ?>"
                                   placeholder="<?php echo $entry_edc; ?>" id="input-edc" class="form-control"/>
                            <?php if ($error_edc) { ?>
                            <div class="text-danger"><?php echo $error_edc; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-gravidity"><?php echo $entry_gravidity; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="gravidity" value="<?php echo $gravidity; ?>"
                                   placeholder="<?php echo $entry_gravidity; ?>" id="input-gravidity" class="form-control"/>
                            <?php if ($error_gravidity) { ?>
                            <div class="text-danger"><?php echo $error_gravidity; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-parity"><?php echo $entry_parity; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="parity" value="<?php echo $parity; ?>"
                                   placeholder="<?php echo $entry_parity; ?>" id="input-parity" class="form-control"/>
                            <?php if ($error_parity) { ?>
                            <div class="text-danger"><?php echo $error_parity; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-vaginaldelivery"><?php echo $entry_vaginaldelivery; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="vaginaldelivery" value="<?php echo $vaginaldelivery; ?>"
                                   placeholder="<?php echo $entry_vaginaldelivery; ?>" id="input-vaginaldelivery" class="form-control"/>
                            <?php if ($error_vaginaldelivery) { ?>
                            <div class="text-danger"><?php echo $error_vaginaldelivery; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-aesarean"><?php echo $entry_aesarean; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="aesarean" value="<?php echo $aesarean; ?>"
                                   placeholder="<?php echo $entry_aesarean; ?>" id="input-aesarean" class="form-control"/>
                            <?php if ($error_aesarean) { ?>
                            <div class="text-danger"><?php echo $error_aesarean; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-spontaneousabortion"><?php echo $entry_spontaneousabortion; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="spontaneousabortion" value="<?php echo $spontaneousabortion; ?>"
                                   placeholder="<?php echo $entry_spontaneousabortion; ?>" id="input-spontaneousabortion" class="form-control"/>
                            <?php if ($error_spontaneousabortion) { ?>
                            <div class="text-danger"><?php echo $error_spontaneousabortion; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-drug_inducedabortion"><?php echo $entry_drug_inducedabortion; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="drug_inducedabortion" value="<?php echo $drug_inducedabortion; ?>"
                                   placeholder="<?php echo $entry_drug_inducedabortion; ?>" id="input-drug_inducedabortion" class="form-control"/>
                            <?php if ($error_drug_inducedabortion) { ?>
                            <div class="text-danger"><?php echo $error_drug_inducedabortion; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-fetal"><?php echo $entry_fetal; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="fetal" value="<?php echo $fetal; ?>"
                                   placeholder="<?php echo $entry_fetal; ?>" id="input-fetal" class="form-control"/>
                            <?php if ($error_fetal) { ?>
                            <div class="text-danger"><?php echo $error_fetal; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label"><?php echo $entry_highrisk; ?></label>
                        <div class="col-sm-10">
                            <?php if ($highrisk) { ?>
                            <label class="radio-inline">
                                <input type="radio" name="highrisk" value="1" checked="checked"/>
                                <?php echo $text_yes; ?></label>
                            <label class="radio-inline">
                                <input type="radio" name="highrisk" value="0"/>
                                <?php echo $text_no; ?></label>
                            <?php } else { ?>
                            <label class="radio-inline">
                                <input type="radio" name="highrisk" value="1"/>
                                <?php echo $text_yes; ?></label>
                            <label class="radio-inline">
                                <input type="radio" name="highrisk" value="0" checked="checked"/>
                                <?php echo $text_no; ?></label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-highriskfactor"><?php echo $entry_highriskfactor; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="highriskfactor" value="<?php echo $highriskfactor; ?>"
                                   placeholder="<?php echo $entry_highriskfactor; ?>" id="input-highriskfactor" class="form-control"/>
                            <?php if ($error_highriskfactor) { ?>
                            <div class="text-danger"><?php echo $error_highriskfactor; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                </fieldset>
                <fieldset id="address">
                    <legend><?php echo $text_your_address; ?></legend>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-householdregister"><?php echo $entry_householdregister; ?></label>
                        <div class="col-sm-10">
                            <?php if ($householdregister) { ?>
                            <label class="radio-inline">
                                <input type="radio" name="householdregister" value="1" checked="checked"/>
                                <?php echo "北京"; ?></label>
                            <label class="radio-inline">
                                <input type="radio" name="householdregister" value="0"/>
                                <?php echo "外埠"; ?></label>
                            <?php } else { ?>
                            <label class="radio-inline">
                                <input type="radio" name="householdregister" value="1"/>
                                <?php echo "北京"; ?></label>
                            <label class="radio-inline">
                                <input type="radio" name="householdregister" value="0" checked="checked"/>
                                <?php echo "外埠"; ?></label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-zone"><?php echo $entry_zone; ?></label>
                        <div class="col-sm-10">
                            <input type="text" id="input-zone" name="zone_id" value="<?php echo "北京"; ?>" disabled="true">
                            <?php if ($error_zone) { ?>
                            <div class="text-danger"><?php echo $error_zone; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-city"><?php echo $entry_city; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="city" value="<?php echo $city; ?>"
                                   placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control"/>
                            <?php if ($error_city) { ?>
                            <div class="text-danger"><?php echo $error_city; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label"
                               for="input-address-1"><?php echo $entry_address_1; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="address_1" value="<?php echo $address_1; ?>"
                                   placeholder="<?php echo $entry_address_1; ?>" id="input-address-1"
                                   class="form-control"/>
                            <?php if ($error_address_1) { ?>
                            <div class="text-danger"><?php echo $error_address_1; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <!--div class="form-group">
                        <label class="col-sm-2 control-label"
                               for="input-address-2"></label>
                        <div-- class="col-sm-10">
                            <input type="text" name="address_2" id="input-address-2"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label"
                               for="input-postcode"></label>
                       <div class="col-sm-10">
                            <input type="text" name="postcode" id="input-postcode"
                                   class="form-control"/>
                        </div>
                    </div-->
                    <!--div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-country"></label>
                        <div class="col-sm-10">
                            <select name="country_id" id="input-country" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                    </div-->
                    <?php foreach ($custom_fields as $custom_field) { ?>
                    <?php if ($custom_field['location'] == 'address') { ?>
                    <?php if ($custom_field['type'] == 'select') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <select name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                    id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                    class="form-control">
                                <option value=""><?php echo $text_select; ?></option>
                                <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                                <?php if (isset($register_custom_field[$custom_field['custom_field_id']]) && $custom_field_value['custom_field_value_id'] == $register_custom_field[$custom_field['custom_field_id']]) { ?>
                                <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"
                                        selected="selected"><?php echo $custom_field_value['name']; ?></option>
                                <?php } else { ?>
                                <option value="<?php echo $custom_field_value['custom_field_value_id']; ?>"><?php echo $custom_field_value['name']; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'radio') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <div>
                                <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                                <div class="radio">
                                    <?php if (isset($register_custom_field[$custom_field['custom_field_id']]) && $custom_field_value['custom_field_value_id'] == $register_custom_field[$custom_field['custom_field_id']]) { ?>
                                    <label>
                                        <input type="radio"
                                               name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                               value="<?php echo $custom_field_value['custom_field_value_id']; ?>"
                                               checked="checked"/>
                                        <?php echo $custom_field_value['name']; ?></label>
                                    <?php } else { ?>
                                    <label>
                                        <input type="radio"
                                               name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                               value="<?php echo $custom_field_value['custom_field_value_id']; ?>"/>
                                        <?php echo $custom_field_value['name']; ?></label>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'checkbox') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <div>
                                <?php foreach ($custom_field['custom_field_value'] as $custom_field_value) { ?>
                                <div class="checkbox">
                                    <?php if (isset($register_custom_field[$custom_field['custom_field_id']]) && in_array($custom_field_value['custom_field_value_id'], $register_custom_field[$custom_field['custom_field_id']])) { ?>
                                    <label>
                                        <input type="checkbox"
                                               name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]"
                                               value="<?php echo $custom_field_value['custom_field_value_id']; ?>"
                                               checked="checked"/>
                                        <?php echo $custom_field_value['name']; ?></label>
                                    <?php } else { ?>
                                    <label>
                                        <input type="checkbox"
                                               name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>][]"
                                               value="<?php echo $custom_field_value['custom_field_value_id']; ?>"/>
                                        <?php echo $custom_field_value['name']; ?></label>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'text') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <input type="text"
                                   name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                   value="<?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>"
                                   placeholder="<?php echo $custom_field['name']; ?>"
                                   id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                   class="form-control"/>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'textarea') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <textarea
                                    name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                    rows="5" placeholder="<?php echo $custom_field['name']; ?>"
                                    id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                    class="form-control"><?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?></textarea>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'file') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <button type="button"
                                    id="button-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                    data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i
                                        class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
                            <input type="hidden"
                                   name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                   value="<?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : ''); ?>"/>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'date') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <div class="input-group date">
                                <input type="text"
                                       name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                       value="<?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>"
                                       placeholder="<?php echo $custom_field['name']; ?>" data-date-format="YYYY-MM-DD"
                                       id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                       class="form-control"/>
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'time') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <div class="input-group time">
                                <input type="text"
                                       name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                       value="<?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>"
                                       placeholder="<?php echo $custom_field['name']; ?>" data-date-format="HH:mm"
                                       id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                       class="form-control"/>
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if ($custom_field['type'] == 'datetime') { ?>
                    <div id="custom-field<?php echo $custom_field['custom_field_id']; ?>"
                         class="form-group custom-field" data-sort="<?php echo $custom_field['sort_order']; ?>">
                        <label class="col-sm-2 control-label"
                               for="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"><?php echo $custom_field['name']; ?></label>

                        <div class="col-sm-10">
                            <div class="input-group datetime">
                                <input type="text"
                                       name="custom_field[<?php echo $custom_field['location']; ?>][<?php echo $custom_field['custom_field_id']; ?>]"
                                       value="<?php echo (isset($register_custom_field[$custom_field['custom_field_id']]) ? $register_custom_field[$custom_field['custom_field_id']] : $custom_field['value']); ?>"
                                       placeholder="<?php echo $custom_field['name']; ?>"
                                       data-date-format="YYYY-MM-DD HH:mm"
                                       id="input-custom-field<?php echo $custom_field['custom_field_id']; ?>"
                                       class="form-control"/>
                <span class="input-group-btn">
                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                </span></div>
                            <?php if (isset($error_custom_field[$custom_field['custom_field_id']])) { ?>
                            <div class="text-danger"><?php echo $error_custom_field[$custom_field['custom_field_id']]; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>
                </fieldset>
                <!--fieldset>
                    <legend></legend>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label"
                               for="input-password"></label>
                        <div class="col-sm-10">
                            <input type="password" name="password" id="input-password"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-confirm"></label>
                        <div class="col-sm-10">
                            <input type="password" name="confirm" id="input-confirm" class="form-control"/>
                        </div>
                    </div>
                </fieldset-->
                <!--fieldset>
                    <legend></legend>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                        </div>
                    </div>
                </fieldset-->
                <!--fieldset>
                </fieldset-->
                <div class="buttons">
                    <div class="pull-right">
                        <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary"/>
                    </div>
                </div>
            </form>
            <?php echo $content_bottom; ?></div>
        <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
    // Sort the custom fields
    $('#account .form-group[data-sort]').detach().each(function () {
        if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#account .form-group').length) {
            $('#account .form-group').eq($(this).attr('data-sort')).before(this);
        }

        if ($(this).attr('data-sort') > $('#account .form-group').length) {
            $('#account .form-group:last').after(this);
        }

        if ($(this).attr('data-sort') == $('#account .form-group').length) {
            $('#account .form-group:last').after(this);
        }

        if ($(this).attr('data-sort') < -$('#account .form-group').length) {
            $('#account .form-group:first').before(this);
        }
    });

    $('#address .form-group[data-sort]').detach().each(function () {
        if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#address .form-group').length) {
            $('#address .form-group').eq($(this).attr('data-sort')).before(this);
        }

        if ($(this).attr('data-sort') > $('#address .form-group').length) {
            $('#address .form-group:last').after(this);
        }

        if ($(this).attr('data-sort') == $('#address .form-group').length) {
            $('#address .form-group:last').after(this);
        }

        if ($(this).attr('data-sort') < -$('#address .form-group').length) {
            $('#address .form-group:first').before(this);
        }
    });

    $('input[name=\'customer_group_id\']').on('change', function () {
        $.ajax({
            url: 'index.php?route=account/register/customfield&customer_group_id=' + this.value,
            dataType: 'json',
            success: function (json) {
                $('.custom-field').hide();
                $('.custom-field').removeClass('required');

                for (i = 0; i < json.length; i++) {
                    custom_field = json[i];

                    $('#custom-field' + custom_field['custom_field_id']).show();

                    if (custom_field['required']) {
                        $('#custom-field' + custom_field['custom_field_id']).addClass('required');
                    }
                }


            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });


    $('input[name=\'customer_group_id\']:checked').trigger('change');
    //--></script>
<script type="text/javascript"><!--
    $('button[id^=\'button-custom-field\']').on('click', function () {
        var node = this;

        $('#form-upload').remove();

        $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

        $('#form-upload input[name=\'file\']').trigger('click');

        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function () {
            if ($('#form-upload input[name=\'file\']').val() != '') {
                clearInterval(timer);

                $.ajax({
                    url: 'index.php?route=tool/upload',
                    type: 'post',
                    dataType: 'json',
                    data: new FormData($('#form-upload')[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $(node).button('loading');
                    },
                    complete: function () {
                        $(node).button('reset');
                    },
                    success: function (json) {
                        $(node).parent().find('.text-danger').remove();

                        if (json['error']) {
                            $(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
                        }

                        if (json['success']) {
                            alert(json['success']);

                            $(node).parent().find('input').val(json['code']);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });
            }
        }, 500);
    });
    //--></script>
<script type="text/javascript"><!--
    $('.date').datetimepicker({
        pickTime: false
    });

    $('.time').datetimepicker({
        pickDate: false
    });

    $('.datetime').datetimepicker({
        pickDate: true,
        pickTime: true
    });
    //--></script>
<script type="text/javascript"><!--
    $('select[name=\'country_id\']').on('change', function () {
        $.ajax({
            url: 'index.php?route=account/account/country&country_id=' + this.value,
            dataType: 'json',
            beforeSend: function () {
                $('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
            },
            complete: function () {
                $('.fa-spin').remove();
            },
            success: function (json) {
                if (json['postcode_required'] == '1') {
                    $('input[name=\'postcode\']').parent().parent().addClass('required');
                } else {
                    $('input[name=\'postcode\']').parent().parent().removeClass('required');
                }

                html = '<option value=""><?php echo $text_select; ?></option>';

                if (json['zone'] && json['zone'] != '') {
                    for (i = 0; i < json['zone'].length; i++) {
                        html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                        if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
                            html += ' selected="selected"';
                        }

                        html += '>' + json['zone'][i]['name'] + '</option>';
                    }
                } else {
                    html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
                }

                $('select[name=\'zone_id\']').html(html);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('select[name=\'country_id\']').trigger('change');
    //--></script>



<script type="text/javascript">
    function countindex() {

        var bmiindex =document.getElementById("input-weight").value/(Math.pow(document.getElementById("input-height").value,2)/10000);
        var bmiindex =bmiindex.toFixed(2);

        document.getElementById("input-bmiindex").innerHTML = bmiindex;

        if(bmiindex<"18.5"){

           // echo "过轻"; $bmitype = "0";
            document.getElementById("input-bmitype").innerHTML = "过轻";
        }
        else if(bmiindex<"25"){
            //echo "正常"; $bmitype = "1";
            document.getElementById("input-bmitype").innerHTML = "正常";
        }
        else if(bmiindex<"28"){
            //echo "过重"; $bmitype = "2";
            document.getElementById("input-bmitype").innerHTML = "过重";
        }
        else if(bmiindex<"32"){
            //echo "肥胖"; $bmitype = "3";
            document.getElementById("input-bmitype").innerHTML = "肥胖";
        }
        else{
            //echo "非常肥胖"; $bmitype = "4";
            document.getElementById("input-bmitype").innerHTML = "非常肥胖";
        }

    }


</script>
<?php echo $footer; ?>
