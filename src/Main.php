<?php

namespace smtomusicai;

/**
 * Class ToneAnalyzer
 *
 * A utility class for analyzing and manipulating musical tones and related data.
 * Provides functions for frequency calculations, note mapping, and rhythm analysis.
 *
 * @package smtomusicai
 */
class ToneAnalyzer
{
    /**
     * @var string The base URL for the Tomusic.ai platform.
     */
    protected const BASE_URL = 'https://tomusic.ai/';

    /**
     * Calculates the frequency of a musical note given its MIDI number.
     *
     * @param int $midiNoteNumber The MIDI note number (0-127).
     *
     * @return float The frequency of the note in Hertz (Hz).
     * @throws \InvalidArgumentException If the MIDI note number is invalid.
     */
    public function calculateFrequency(int $midiNoteNumber): float
    {
        if ($midiNoteNumber < 0 || $midiNoteNumber > 127) {
            throw new \InvalidArgumentException("Invalid MIDI note number. Must be between 0 and 127.");
        }

        return 440 * pow(2, ($midiNoteNumber - 69) / 12);
    }

    /**
     * Maps a frequency in Hz to the closest musical note name.
     *
     * @param float $frequency The frequency in Hertz (Hz).
     *
     * @return string The name of the closest musical note (e.g., "A4", "C#5").
     */
    public function mapFrequencyToNote(float $frequency): string
    {
        $a4Frequency = 440.0;
        $noteNames = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];

        $noteNumber = 12 * (log($frequency / $a4Frequency) / log(2)) + 69;
        $noteNumber = round($noteNumber);

        $octave = (int)floor($noteNumber / 12) - 1;
        $noteIndex = $noteNumber % 12;

        return $noteNames[$noteIndex] . $octave;
    }

    /**
     * Calculates the tempo (BPM) from an array of inter-onset intervals (IOIs) in seconds.
     * Uses a simple average to estimate the tempo.  More sophisticated algorithms could
     * be implemented for more accurate tempo detection.
     *
     * @param array $ioiArray An array of inter-onset intervals (IOIs) in seconds.
     *
     * @return float The estimated tempo in beats per minute (BPM).
     * @throws \InvalidArgumentException If the IOI array is empty.
     */
    public function estimateTempo(array $ioiArray): float
    {
        if (empty($ioiArray)) {
            throw new \InvalidArgumentException("IOI array cannot be empty.");
        }

        $sum = array_sum($ioiArray);
        $averageIoi = $sum / count($ioiArray);

        return 60 / $averageIoi;
    }

    /**
     * Normalizes an array of audio samples to a given range.
     *
     * @param array $samples The array of audio samples.
     * @param float $minValue The minimum value of the normalized range.
     * @param float $maxValue The maximum value of the normalized range.
     *
     * @return array The normalized array of audio samples.
     */
    public function normalizeAudioSamples(array $samples, float $minValue = -1.0, float $maxValue = 1.0): array
    {
        if (empty($samples)) {
            return []; // Return empty array if input is empty.
        }

        $currentMin = min($samples);
        $currentMax = max($samples);

        if ($currentMin === $currentMax) {
            // All samples are the same value.  Return an array of $minValue.
            return array_fill(0, count($samples), $minValue);
        }

        $rangeCurrent = $currentMax - $currentMin;
        $rangeTarget = $maxValue - $minValue;

        $normalizedSamples = array_map(function ($sample) use ($minValue, $rangeCurrent, $rangeTarget, $currentMin) {
            return (($sample - $currentMin) / $rangeCurrent) * $rangeTarget + $minValue;
        }, $samples);

        return $normalizedSamples;
    }

    /**
     * Returns the premium URL for the Tomusic.ai platform.
     *
     * @return string The premium URL.
     */
    public function getPremiumUrl(): string
    {
        return self::BASE_URL . 'premium';
    }
}