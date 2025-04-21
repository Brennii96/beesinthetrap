## Installation

To get started, you must have Docker OR php8.4-cli and composer installed. For speed and ease of use, Docker is
recommended.

If docker is installed, run:

```bash
make start
```

This will build the docker image then throw you into the game. If you want to run the game automatically, run the
following:

```bash
make ARGS="--auto" start
```

To run tests:

```bash
make test
```

This will build a development image and auto run the phpunit tests.

If you don't want to use Docker, you will have to install PHP8.4-cli and composer then install the dependencies:

```bash
composer install --no-dev --optimize-autoloader
```

Then make the beesinthetrap file executable:

```bash
chmod +x bin/beesinthetrap
```

From there the game can be played either automatically or interactively:

```bash
./bin/beesinthetrap
```

Follow the instructions until the end OR:

```bash
./bin/beesinthetrap --auto
```

If not autoplaying, there's an option to quit early, type either `quit` or `exit` when asked for input.

There are settings in the config/services.yaml for "difficulty" essentially the chances of a player or a bee landing a
hit. Also, if you want the game to feel more natural and slightly less robotic there's the option to add a delay between
turns. These are all floats, hit chance should be a number between 0 and 1, delay can be anything greater than 0 but
bear in mind 0.2 === 2ms.

```yaml
parameters:
  game.player_hit_chance: 0.5
  game.bee_hit_chance: 0.3
  game.delay_between_turns: 0
```
