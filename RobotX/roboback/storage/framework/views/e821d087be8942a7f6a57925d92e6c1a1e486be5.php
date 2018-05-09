<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <!-- <div class="panel-heading">Behaviors</div> -->

                    <div class="panel-body">
                        <p class="list-header">
                            <span class="behavior-header">Behaviors</span>
                            <span>
                                <a href="<?php echo e(route('behaviors.create')); ?>" class="btn btn-default align-right">
                                    <i class="fa fa-plus action-icon" title="New behavior"></i>
                                </a>
                            </span>
                            <span>
                                <span class="filter-label">Search:<span> <input id="bhv-search" onkeyup="doBhvSearch();"/>
                            </span>
                            <span>
                                <span class="filter-label">Language:</span>
                                <select class="filter-select" id="bhv-filter-language" onchange="doBhvSearch();">
                                    <option value="ALL" selected="selected">&nbsp;</option>
                                    <option value="Dutch">Dutch</option>
                                    <option value="English">English</option>
                                    <option value="German">German</option>
                                    <option value="French">French</option>
                                </select>
                            </span>
                            <span>
                                <span class="filter-label">Base Menu:</span>
                                <select class="filter-select" id="bhv-filter-basemenu" onchange="doBhvSearch();">
                                    <option value="ALL" selected="selected">&nbsp;</option>
                                    <option value="Dance menu">Dance</option>
                                    <option value="Greetings menu">Activities</option>
                                    <option value="Interaction menu">Interaction</option>
                                    <option value="Presentation menu">Presentation</option>
                                </select>
                            </span>
                            <span>
                                <span class="filter-label">Robot:<span>
                                <select class="filter-select-robot" id="bhv-filter-robot" onchange="doBhvSearch();">
                                    <option value="ALL" selected="selected">&nbsp;</option>
                                    <?php $__currentLoopData = $robots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $robot): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                        <option value="<?php echo $robot->name; ?>"><?php echo $robot->name; ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                </select>
                            </span>
                            
                        </p>

                        <table class="table table-striped">
                            <tr>
                                <th></th>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Type of Behavior</th>
                                <th>Language</th>
                                <!-- Accepted as new table -->
                                <th>&nbsp;</th>
                                <?php if(\App\RoleUsers::where('user_id', Auth::id())->first()->role_id <= 2): ?>
                                    <th>Accepted</th>
                                <?php endif; ?>
                            </tr>
                            <?php if(!$behaviors->count()): ?>
                                <tr>
                                    <td colspan="5">No behaviors added yet.</td>
                                </tr>
                            <?php endif; ?>

                            <?php $__currentLoopData = $behaviors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $behavior): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr class="bhv-row" id="bhv-id-<?php echo e($behavior->id); ?>">
                                    <td class="behavior-actions">
                                        <a href="<?php echo e(route('behaviors.edit', $behavior->id)); ?>" data-title="Edit behavior <?php echo e($behavior->name); ?>" data-toggle="">
                                            <i class="fa fa-pencil pull-left list-icon"></i>
                                        </a>
                                        <a href="<?php echo e(route('behaviors.destroy', $behavior->id)); ?>" class="remove-confirm">
                                            <i class="fa fa-trash pull-right list-icon"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if(isset($behavior->icondata)): ?>
                                            <img class="list-icon-icon" src="<?php echo e('data:image/' . $behavior->icondata->type . ';base64,' . $behavior->icondata->icon); ?>"/>
                                        <?php else: ?>
                                            <i class="fa fa-smile-o list-icon"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="bhv-name"><?php echo e($behavior->name); ?></td>
                                    <td class="bhv-descr"><?php echo e($behavior->description); ?></td>
                                    <td><?php echo e($behavior->behaviortype); ?></td>
                                    <td class="bhv-lang"><?php echo e($behavior->language); ?></td>
                                    <td class="bhv-rbts"><?php if(isset($behavior->sayanimation) && $behavior->sayanimation == 'true'): ?><i class="fa fa-child"></i><?php else: ?> &nbsp; <?php endif; ?></td>
                                    <td class="bhv-base" style="display: none"><?php echo e($behavior->basemenu); ?></td>
                                    <td class="bhv-rbts" style="display: none"><?php echo e($behavior->robots); ?></td>

                                    <!--New buttons for accepted table-->
                                    <th>
                                        <?php if(\App\RoleUsers::where('user_id', Auth::id())->first()->role_id <= 2): ?>
                                            <button type="button" value= 1 id="approved" class="btn btn-success response"><i class="fa fa-check">
                                            </i>Accept</button>  <button type="button" value= 0 id="declined" class="btn btn-danger response">
                                            <i class="fa fa-times"></i>Decline</button>
                                        <?php endif; ?>
                                    </th>
                                    
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
        function doBhvSearch() {
            var search   = $("input#bhv-search").val().toLowerCase();
            var language = $("select#bhv-filter-language").val();
            var basemenu = $("select#bhv-filter-basemenu").val();
            var robot    = $("select#bhv-filter-robot").val();
            $(".bhv-row").each(function(index, elem) {
                if (search.length > 0 || language !== 'ALL' || basemenu !== 'ALL' || robot !== 'ALL') {
                    var name  = -1;
                    var descr = -1;
                    var lang  = -1;
                    var base  = -1;
                    var rbt   = -1;
                    if (search.length > 0) {
                        name = $(elem).children("td.bhv-name").text().toLowerCase().indexOf(search);
                    } else {
                        name = 0;
                    }
                    if (search.length > 0) {
                        descr = $(elem).children("td.bhv-descr").text().toLowerCase().indexOf(search);
                    } else {
                        descr = 0;
                    }
                    if (language !== 'ALL') {
                        lang = $(elem).children("td.bhv-lang").text().indexOf(language);
                    } else {
                        lang = 0;
                    }
                    if (basemenu !== 'ALL') {
                        base = $(elem).children("td.bhv-base").text().indexOf(basemenu);
                    } else {
                        base = 0;
                    }
                    if (robot !== 'ALL') {
                        rbt = $(elem).children("td.bhv-rbts").text().indexOf(robot);
                    } else {
                        rbt = 0;
                    }
                    // console.log(index + " bhv-id=" + $(elem).attr("id"));
                    if ((name > -1 || descr > -1) && lang > -1 && base > -1 && rbt > -1) {
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