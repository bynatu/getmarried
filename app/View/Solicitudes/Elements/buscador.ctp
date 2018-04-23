<?php
echo $this->Form->create(
    'Buscador',
    array(
        'class' => 'buscador',
        'type' => 'get',
        'url' => array(
            'controller' => 'authors',
            'action' => 'index'
        ),
    )
);
?>
<div class="row">
    <div class="medium-3 columns">
        <?php echo $this->Form->input(
            'name',
            array(
                'label' => __('Name'),
                'type' => 'text',
            )
        ); ?>
    </div>
    <div class="medium-3 columns">
        <?php echo $this->Form->input(
            'surname',
            array(
                'label' => __('Surname'),
                'type' => 'text',
            )
        ); ?>
    </div>
    <div class="medium-3 columns">
        <?php echo $this->Form->input(
            'phone',
            array(
                'label' => __('Phone'),
                'type' => 'tel',
            )
        ); ?>
    </div>
    <div class="medium-2 columns">
        <?php echo $this->Form->input(
            'birth_date',
            array(
                'label' => __('Birthdate'),
                'type' => 'text',
                'autocomplete' => 'off',
                'class' => 'fecha-js'
            )
        ); ?>
    </div>
    <div class="medium-1 columns end p-form">
        <?php
            echo $this->Form->button(
                '',
                array(
                    'type' => 'submit',
                    'class' => 'btn-default ion-ios-search',
                    'escape' => false,
                )
            );
        ?>
    </div>
</div>
<?php echo $this->Form->end();