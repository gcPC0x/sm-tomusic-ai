# sm-tomusic-ai: A Simple Music Generation Toolkit

This repository provides a lightweight toolkit for interacting with music generation models. It offers a streamlined interface for generating musical pieces based on various input parameters. The primary goal is to provide developers with an easy-to-use library for integrating AI-powered music creation into their projects.

## Features

*   **Simplified API:** Focuses on ease of use, abstracting away the complexities of the underlying models.
*   **Multiple Output Formats:** Supports outputting generated music in standard MIDI format.
*   **Configurable Parameters:** Allows users to adjust key parameters such as tempo, key signature, and instrument selection.
*   **Lightweight Dependency Footprint:** Minimizes external dependencies for easier integration.
*   **Example Scripts:** Includes example scripts demonstrating common use cases.

## Installation

To install `sm-tomusic-ai`, use pip:

pip install sm-tomusic-ai

This will install the library and its required dependencies.

## Quick Start

Here's a basic example of how to generate a short musical piece:

from sm_tomusic_ai import MusicGenerator

# Initialize the MusicGenerator
generator = MusicGenerator()

# Set parameters (optional)
generator.tempo = 120
generator.key_signature = 'C Major'
generator.instrument = 'Piano'

# Generate music
music = generator.generate(length=16) # Generates 16 bars of music

# Save the music to a MIDI file
generator.save_midi(music, 'output.mid')

print("Music generated and saved to output.mid")

This code snippet demonstrates the basic workflow: initializing the `MusicGenerator`, optionally setting parameters, generating music, and saving it to a MIDI file. Further customization options are available through the `MusicGenerator` class.

## Resources and Credits

This toolkit leverages research and development in music AI. For more information about the underlying technology and related projects, visit ToMusic AI.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.