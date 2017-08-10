<?php

namespace Tvsjke\ImagenariumBundle\Form;

use Tvsjke\ImagenariumBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
    $builder->add('image', FileType::class, ['data_class' => null,]);
    $builder->add('description', TextareaType::class);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(['data_class' => Post::class,]);
  }
}