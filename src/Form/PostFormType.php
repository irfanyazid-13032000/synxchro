<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Genre; // Import Entity Genre
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // Import ChoiceType
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre',
                'choices' => $options['genres'], // Mengambil pilihan genre dari opsi
                'placeholder' => 'Choose an option', // Placeholder untuk select
                'choice_label' => 'name', // Field dari entity Genre yang akan ditampilkan sebagai label
                'required' => true,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'genres' => [], // Opsi untuk menyimpan daftar genre
        ]);
    }
}
