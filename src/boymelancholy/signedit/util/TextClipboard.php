<?php

declare(strict_types=1);

namespace boymelancholy\signedit\util;

use pocketmine\block\utils\SignText;
use pocketmine\player\Player;

class TextClipboard
{
    /** @var SignText[] */
    private array $textClipboards;

    /** @var Player */
    private Player $player;

    public function __construct(Player $player)
    {
        $this->textClipboards = [];
        $this->player = $player;
    }

    /**
     * @return string
     */
    public function getOwner(): string
    {
        return $this->player->getName();
    }

    /**
     * @param SignText $text
     * @return bool
     */
    public function add(SignText $text): bool
    {
        foreach ($this->textClipboards as $signText) {
            if ($signText->getLines() === $text->getLines()) {
                return false;
            }
        }
        $this->textClipboards[] = $text;
        sort($this->textClipboards);
        return true;
    }

    /**
     * @param int $index
     * @return SignText|null
     */
    public function remove(int $index): ?SignText
    {
        if ($this->get($index) !== null) {
            $text = $this->textClipboards[$index];
            unset($this->textClipboards[$index]);
            sort($this->textClipboards);
            return $text;
        }
        return null;
    }

    /**
     * @param int $index
     * @return SignText|null
     */
    public function get(int $index): ?SignText
    {
        return $this->textClipboards[$index] ?? null;
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return count($this->textClipboards);
    }

    /**
     * @return SignText[]
     */
    public function getAll(): array
    {
        return $this->textClipboards ?? [];
    }


    /** @var TextClipboard[] */
    public static array $clipboards = [];

    /**
     * @param Player $player
     * @return TextClipboard
     */
    public static function getClipBoard(Player $player): TextClipboard
    {
        foreach (self::$clipboards as $cb) {
            if ($cb->getOwner() === $player->getName()) {
                return $cb;
            }
        }
        $newClipboards = new TextClipboard($player);
        self::$clipboards[] = $newClipboards;
        return $newClipboards;
    }

    /**
     * @param Player $player
     */
    public static function deleteClipboard(Player $player)
    {
        for ($i = 0; $i < count(self::$clipboards); ++$i) {
            if (self::$clipboards[$i]->getOwner() === $player->getName()) {
                unset(self::$clipboards[$i]);
            }
        }
    }
}