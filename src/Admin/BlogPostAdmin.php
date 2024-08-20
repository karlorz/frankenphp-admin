<?php
// src/Admin/BlogPostAdmin.php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

final class BlogPostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form): void
    {
        $form
        ->add('title', TextType::class)
        ->add('body', TextareaType::class)
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        // ... configure $list
    }
}