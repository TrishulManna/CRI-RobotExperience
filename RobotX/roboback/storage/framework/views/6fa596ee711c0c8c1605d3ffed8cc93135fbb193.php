<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <!-- <div class="panel-heading">Texts</div> -->

                    <div class="panel-body">
                        <p class="list-header">
                            <span class="text-header">Texts</span>
                            
                            <a href="<?php echo e(route('texts.create')); ?>" class="btn btn-default align-right">
                                <i class="fa fa-plus action-icon" title="New text"></i>
                            </a>
                            <span>
                                <span class="filter-label">Search:<span> <input id="text-search" onkeyup="doTextSearch();"/>
                            </span>
                            <span>
                                <span class="filter-label">Language:</span>
                                <select class="filter-select" id="text-filter-language" onchange="doTextSearch();">
                                    <option value="ALL" selected="selected">&nbsp;</option>
                                    <option value="Dutch">Dutch</option>
                                    <option value="English">English</option>
                                    <option value="German">German</option>
                                    <option value="French">French</option>
                                </select>
                            </span>
                            <span>
                                <span class="filter-label">Base Menu:</span>
                                <select class="filter-select" id="text-filter-basemenu" onchange="doTextSearch();">
                                    <option value="ALL" selected="selected">&nbsp;</option>
                                    <option value="Dance menu">Compliments</option>
                                    <option value="Greetings menu">Greetings</option>
                                    <option value="Interaction menu">Interaction</option>
                                    <option value="Presentation menu">Robotanswers</option>
                                </select>
                            </span>
                        </p>

                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Text</th>
                                <th>Language</th>
                            </tr>
                            <?php if(!$texts->count()): ?>
                                <tr>
                                    <td colspan="4">No texts added yet.</td>
                                </tr>
                            <?php endif; ?>

                            <?php $__currentLoopData = $texts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $text): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr class="text-row" id="text-id-<?php echo e($text->id); ?>">
                                    <td class="text-actions">
                                        
                                        <a href="<?php echo e(route('texts.edit', $text->id)); ?>">
                                            <i class="fa fa-pencil pull-left list-icon"></i>
                                        </a>
                                        <a href="<?php echo e(route('texts.destroy', $text->id)); ?>" class="remove-confirm">
                                            <i class="fa fa-trash pull-right list-icon"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if( isset($text->icondata ) ): ?>
                                            <?php echo Form::hidden('icon', $text->icondata->id, ['id' => 'text-icon']); ?>

                                            <img class="list-icon-icon" src="<?php echo e('data:image/' . $text->icondata->type . ';base64,' . $text->icondata->icon); ?>"/>
                                        <?php else: ?>
                                            <?php echo Form::hidden('icon', 'fa-commenting-o', ['id' => 'text-icon']); ?>

                                            <i class="fa fa-commenting-o list-icon"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-name"><?php echo e($text->name); ?></td>
                                    <td class="text-text"><?php echo e($text->text); ?></td>
                                    <td class="text-lang"><?php echo e($text->language); ?></td>
                                    <td class="text-base" style="display: none"><?php echo e($text->basemenu); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        function doTextSearch() {
            var search   = $("input#text-search").val().toLowerCase();
            var language = $("select#text-filter-language").val();
            var basemenu = $("select#text-filter-basemenu").val();
            $(".text-row").each(function(index, elem) {
                if (search.length > 0 || language !== 'ALL' || basemenu !== 'ALL') {
                    var name = -1;
                    var text = -1;
                    var lang = -1;
                    var base = -1;
                    if (search.length > 0) {
                        name = $(elem).children("td.text-name").text().toLowerCase().indexOf(search);
                    } else {
                        name = 0;
                    }
                    if (search.length > 0) {
                        text = $(elem).children("td.text-text").text().toLowerCase().indexOf(search);
                    } else {
                        text = 0;
                    }
                    if (language !== 'ALL') {
                        lang = $(elem).children("td.text-lang").text().indexOf(language);
                    } else {
                        lang = 0;
                    }
                    if (basemenu !== 'ALL') {
                        base = $(elem).children("td.text-base").text().indexOf(basemenu);
                    } else {
                        base = 0;
                    }
                    // console.log(index + " bhv-id=" + $(elem).attr("id"));
                    if ((name > -1 || text > -1) && lang > -1 && base > -1) {
                        $(elem).show();
                    } else {
                        $(elem).hide();
                    }
                } else {
                    $(elem).show();
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>