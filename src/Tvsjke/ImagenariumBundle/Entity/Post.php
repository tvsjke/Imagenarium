<?php


namespace Tvsjke\ImagenariumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @ORM\Entity(repositoryClass="Tvsjke\ImagenariumBundle\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post {

  const NUM_ITEMS = 10;

  /**
   * @var int
   *
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @var string
   *
   * @ORM\Column(type="string")
   */
  private $title;

  /**
   * @var string
   *
   * @ORM\Column(type="string")
   */
  private $category;

  /**
   * @var string
   *
   * @ORM\Column(type="text")
   */
  private $description;

  /**
   * @var string
   *
   * @ORM\Column(type="string")
   */
  private $image;

  public function getId() {
    return $this->id;
  }

  public function getTitle() {
    return $this->title;
  }

  /**
   * @param string $title
   */
  public function setTitle($title) {
    $this->title = $title;
  }

  public function getCategory() {
    return $this->category;
  }

  /**
   * @param string $category
   */
  public function setCategory($category) {
    $this->category = $category;
  }

  public function getDescription() {
    return $this->description;
  }

  /**
   * @param string $description
   */
  public function setDescription($description) {
    $this->description = $description;
  }

  public function getImage() {
    return $this->image;
  }

  /**
   * @param string $image
   */
  public function setImage($image) {
    $this->image = $image;
  }

  public static function loadValidatorMetadata(ClassMetadata $metadata) {
    $metadata->addPropertyConstraint('title', new NotBlank());
    $metadata->addPropertyConstraint('category', new NotBlank());
    $metadata->addPropertyConstraint('image', new NotBlank());
    $metadata->addPropertyConstraint('description', new Length(['min' => 10]));
  }
}