<?php


namespace Tvsjke\ImagenariumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Tvsjke\ImagenariumBundle\Repository\PostRepository")
 * @ORM\Table(name="post")
 */
class Post {

  const NUM_ITEMS = 5;

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
   *
   * @Assert\NotBlank(message="Should not be empty")
   */
  private $title;

  /**
   * @var string
   *
   * @ORM\Column(type="string")
   *
   * @Assert\NotBlank(message="Should not be empty")
   */
  private $category;

  /**
   * @var string
   *
   * @ORM\Column(type="text")
   *
   * @Assert\NotBlank(message="Should not be empty")
   */
  private $description;

  /**
   * @var string
   *
   * @ORM\Column(type="string")
   *
   * @Assert\NotBlank(message="Please, upload the image")
   * @Assert\File(maxSize="5242880", mimeTypes={ "image/jpeg", "image/jpg", "image/png", "image/gif" })
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
}