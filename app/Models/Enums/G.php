<?php

namespace App\Models\Enums;

enum G: int
{
    case SimonSays = 1001;
    case Trivial = 1002;
    case Barrage = 1003;
    case FifteenGreen = 1004;
    case Grid = 1200;
    case FlashMines = 1201;
    case Strategy = 1202;
    case Zones = 1203;
    case Words = 2002;
    case Numbers = 2003;
    case Relay = 2004;
    case Sequence = 2005;
    case Spellinator = 2007;
    case MegaGrid = 2200;
    case Jigsaw = 2201;
    case Sharpshooter = 2202;
    case OrderUp = 2203;
    case MegaZones = 2204;
    case Statues = 2205;
    case MegaRelay = 2208;
    case Gridlock = 2209;
    case Maze = 2300;
    case Gauntlet = 2301;
    case Zap = 2302;
    case Defuse = 2303;
    case LaserRelay = 2305;
    case Bop = 2404;
    case Labyrinth = 2405;
    case Flip = 2501;
    case Dartmouth = 2503;
    case Asteroids = 2504;
    case Terminal = 2505;
    case Seeker = 2506;
    case Wormholes = 2600;
    case Jumble = 2601;
    case Oddball = 2602;
    case Stopwatch = 2604;
    case Gems = 2701;
    case Link = 2702;
    case Undercover = 2704;
    case BulletTrain = 2706;
    case Mines = 2703;
    case Supermarket = 2800;
    case InsideOut = 2801;
    case Spot = 2802;

    public function label(): string
    {
        return match ($this) {
            self::SimonSays => 'Simon Says',
            self::Trivial => 'Trivial',
            self::Barrage => 'Barrage',
            self::FifteenGreen => '15 Green',
            self::Grid => 'Grid',
            self::FlashMines => 'Flash Mines',
            self::Strategy => 'Strategy',
            self::Zones => 'Zones',
            self::Words => 'Words',
            self::Numbers => 'Numbers',
            self::Relay => 'Relay',
            self::Sequence => 'Sequence',
            self::Spellinator => 'Spellinator',
            self::MegaGrid => 'Mega Grid',
            self::Jigsaw => 'Jigsaw',
            self::Sharpshooter => 'Sharpshooter',
            self::OrderUp => 'Order Up',
            self::MegaZones => 'Mega Zones',
            self::Statues => 'Statues',
            self::MegaRelay => 'Mega Relay',
            self::Gridlock => 'Gridlock',
            self::Maze => 'Maze',
            self::Gauntlet => 'Gauntlet',
            self::Zap => 'Zap',
            self::Defuse => 'Defuse',
            self::LaserRelay => 'Laser Relay',
            self::Bop => 'Bop',
            self::Labyrinth => 'Labyrinth',
            self::Flip => 'Flip',
            self::Dartmouth => 'Dartmouth',
            self::Asteroids => 'Asteroids',
            self::Terminal => 'Terminal',
            self::Seeker => 'Seeker',
            self::Wormholes => 'Wormholes',
            self::Jumble => 'Jumble',
            self::Oddball => 'Oddball',
            self::Stopwatch => 'Stopwatch',
            self::Gems => 'Gems',
            self::Link => 'Link',
            self::Undercover => 'Undercover',
            self::BulletTrain => 'Bullet Train',
            self::Mines => 'Mines',
            self::Supermarket => 'Supermarket',
            self::InsideOut => 'Inside Out',
            self::Spot => 'Spot',
        };
    }

    public function room(): string
    {
        return match ($this) {
            self::SimonSays, self::Trivial, self::Barrage, self::FifteenGreen => 'Hoops',

            self::Grid, self::FlashMines, self::Strategy, self::Zones => 'Grid',

            self::Words, self::Numbers, self::Relay, self::Sequence, self::Spellinator => 'Hide',

            self::MegaGrid, self::Jigsaw, self::Sharpshooter, self::OrderUp, self::MegaZones,
            self::Statues, self::MegaRelay, self::Gridlock => 'Mega Grid',

            self::Maze, self::Gauntlet, self::Zap, self::Defuse, self::LaserRelay => 'Mega Laser',

            self::Bop, self::Labyrinth => 'Control',

            self::Flip, self::Dartmouth, self::Asteroids, self::Terminal, self::Seeker => 'Strike',

            self::Wormholes, self::Jumble, self::Oddball, self::Stopwatch => 'Portals',

            self::Gems, self::Link, self::Undercover, self::BulletTrain, self::Mines => 'Press',

            self::Supermarket, self::InsideOut, self::Spot => 'Scan',
        };
    }

    public function optimalPlayers(): int
    {
        return match ($this) {
            self::Spellinator => 5,
            self::Trivial => 5,
            self::LaserRelay => 3,
            self::Sharpshooter => 5,
            self::FlashMines => 5,
            self::Seeker => 5,
            self::MegaGrid => 5,
            self::Numbers => 5,
            default => 4,
        };
    }
}
