# sm-tomusic-ai: A Simple Music Generation Tool

This package provides a streamlined interface for generating music using a pre-trained AI model. It's designed for developers who want a quick and easy way to integrate music generation capabilities into their projects without needing to manage complex model configurations directly.

## Features

*   **Simplified API:** Generates music with a single function call.
*   **Customizable Parameters:** Allows adjustment of key musical parameters like tempo and key.
*   **Lightweight Dependency:** Minimizes external dependencies for ease of integration.
*   **Cross-Platform Compatibility:** Designed to work on various operating systems.
*   **Asynchronous Generation:** Supports asynchronous music generation to avoid blocking the main thread.
*   **Error Handling:** Provides robust error handling to manage potential issues during the generation process.

## Installation

pip install sm-tomusic-ai

## Quick Start

Here's a basic example of how to use the `sm-tomusic-ai` package to generate a short musical piece:

from sm_tomusic_ai import generate_music

try:
    music_data = generate_music(duration=10, tempo=120, key='C')

    # music_data now contains the generated music data (e.g., MIDI or WAV format)
    # You can then save or play this data.
    with open("output.mid", "wb") as f: # Assuming MIDI output
        f.write(music_data)

    print("Music generated successfully and saved to output.mid")

except Exception as e:
    print(f"An error occurred: {e}")


This code snippet generates 10 seconds of music at a tempo of 120 beats per minute in the key of C. The generated music data is then saved to a file named "output.mid".  Remember to handle potential exceptions, as the music generation process can sometimes encounter errors. The format of `music_data` depends on the underlying model's output format, which is usually MIDI or WAV.

## Resources/Credits

This tool relies on research and models developed by the ToMusic AI team.

## License

MIT License


## References

* [sm-tomusic-ai Official Site](https://tomusic.ai/)