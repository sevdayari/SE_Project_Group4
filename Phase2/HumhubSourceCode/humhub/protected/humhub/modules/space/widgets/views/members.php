<?php

use humhub\modules\user\models\User;
use humhub\widgets\Link;
use humhub\widgets\PanelMenu;
use humhub\modules\user\widgets\Image;
use humhub\modules\space\models\Space;
use yii\helpers\Html;

/* @var User[] $users */
/* @var bool $showListButton */
/* @var string $urlMembersList */
/* @var array $privilegedUserIds */
/* @var int $totalMemberCount */
/* @var array $showListOptions */
?>
<div class="panel panel-default members" id="space-members-panel">
    <?= PanelMenu::widget([
        'id' => 'space-members-panel',
        'extraMenus' => Html::tag('li', Link::asLink(Yii::t('SpaceModule.base', 'Show as List'))->icon('list')->options($showListOptions)),
    ]); ?>
    <div class="panel-heading"<?= Html::renderTagAttributes($showListOptions + ['style' => 'cursor:pointer']) ?>>
        <?= Yii::t('SpaceModule.base', '<strong>Space</strong> members'); ?> (<?= $totalMemberCount ?>)
    </div>
    <div class="panel-body">
        <?php foreach ($users as $user) : ?>
            <?php
            if (in_array($user->id, $privilegedUserIds[Space::USERGROUP_OWNER])) {
                // Show Owner image & tooltip
                echo Image::widget([
                    'user' => $user, 'width' => 32, 'showTooltip' => true,
                    'tooltipText' => Yii::t('SpaceModule.base', 'Owner:') . "\n" . Html::encode($user->displayName),
                    'imageOptions' => ['style' => 'border:1px solid ' . $this->theme->variable('success')]
                ]);
            } elseif (in_array($user->id, $privilegedUserIds[Space::USERGROUP_ADMIN])) {
                // Show Admin image & tooltip
                echo Image::widget([
                    'user' => $user, 'width' => 32, 'showTooltip' => true,
                    'tooltipText' => Yii::t('SpaceModule.base', 'Administrator:') . "\n" . Html::encode($user->displayName),
                    'imageOptions' => ['style' => 'border:1px solid ' . $this->theme->variable('success')]
                ]);
            } elseif (in_array($user->id, $privilegedUserIds[Space::USERGROUP_MODERATOR])) {
                // Show Moderator image & tooltip
                echo Image::widget([
                    'user' => $user, 'width' => 32, 'showTooltip' => true,
                    'tooltipText' => Yii::t('SpaceModule.base', 'Moderator:') . "\n" . Html::encode($user->displayName),
                    'imageOptions' => ['style' => 'border:1px solid ' . $this->theme->variable('info')]
                ]);
            } else {
                // Standard member
                echo Image::widget(['user' => $user, 'width' => 32, 'showTooltip' => true]);
            }
            ?>
        <?php endforeach; ?>

        <?php if ($showListButton) : ?>
            <br>
            <a href="<?= $urlMembersList; ?>" data-target="#globalModal" class="btn btn-default btn-sm"><?= Yii::t('SpaceModule.base', 'Show all'); ?></a>
        <?php endif; ?>

    </div>
</div>