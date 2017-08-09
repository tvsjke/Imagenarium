<?php

namespace Tvsjke\ImagenariumBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder->add('title', TextType::class);
    $builder->add('category', TextType::class);
    $builder->add('image', TextType::class);
    $builder->add('description', TextareaType::class);
  }

  public function configureOptions(OptionsResolver $resolver)
  {

  }

  public function getBlockPrefix()
  {
    return 'post';
  }
}