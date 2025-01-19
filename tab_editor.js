// DEFAULT VALUES
const DEFAULT_BPM = 60;
const DEFAULT_NOTE_SEQUENCE = [
  { e: 0, B: 1, G: 2, D: 2, A: 0 },
  { e: 3, B: 0, G: 0, D: 0, A: 2, E: 3 },
  { e: 1, B: 1, G: 2, D: 2, A: 3, E: 1 },
  { e: 0, B: 0, G: 1, D: 1, A: 2, E: 0 },
];

// GUITAR STUFF
const get_note_list = () => {
  const note_names = [
    "C",
    "C#",
    "D",
    "D#",
    "E",
    "F",
    "F#",
    "G",
    "G#",
    "A",
    "A#",
    "B",
  ];

  let note_list = [];

  for (let octave = 1; octave <= 9; ++octave) {
    for (let note of note_names) {
      note_list.push(note + octave);
    }
  }

  return note_list;
};
const GUITAR_STRING_NAMES = ["e", "B", "G", "D", "A", "E"];
const MIN_FRET = 0;
const MAX_FRET = 22;
const NOTE_LIST = get_note_list();
const FRETBOARD_MAP = {
  e: NOTE_LIST.slice(NOTE_LIST.indexOf("E4")).slice(
    MIN_FRET,
    MAX_FRET - MIN_FRET + 1
  ),
  B: NOTE_LIST.slice(NOTE_LIST.indexOf("B3")).slice(
    MIN_FRET,
    MAX_FRET - MIN_FRET + 1
  ),
  G: NOTE_LIST.slice(NOTE_LIST.indexOf("G3")).slice(
    MIN_FRET,
    MAX_FRET - MIN_FRET + 1
  ),
  D: NOTE_LIST.slice(NOTE_LIST.indexOf("D3")).slice(
    MIN_FRET,
    MAX_FRET - MIN_FRET + 1
  ),
  A: NOTE_LIST.slice(NOTE_LIST.indexOf("A2")).slice(
    MIN_FRET,
    MAX_FRET - MIN_FRET + 1
  ),
  E: NOTE_LIST.slice(NOTE_LIST.indexOf("E2")).slice(
    MIN_FRET,
    MAX_FRET - MIN_FRET + 1
  ),
};

// DOM ELEMENTS
const value = document.querySelector("#bpm-value");
const bpm_slider = document.querySelector("#bpm-slider");
const tabs_container = document.querySelector("#tabs-container");
const add_bar_button = document.querySelector("#add-bar-button");
const play_tabs_button = document.querySelector("#play-tabs-button");

// SONG INFO
let bpm = DEFAULT_BPM;
let note_sequence = DEFAULT_NOTE_SEQUENCE;

const synth = new Tone.PolySynth(Tone.Synth).toDestination();
Tone.getTransport().bpm.value = bpm;
bpm_slider.value = bpm;
value.textContent = bpm;

bpm_slider.addEventListener("input", (event) => {
  bpm = event.target.value;
  value.textContent = bpm;
  Tone.getTransport().bpm.value = bpm;
});

add_bar_button.addEventListener("click", (_) => {
  for (let i = 0; i < 4; ++i) {
    note_sequence.push({});
  }

  draw_tabs();
});

play_tabs_button.addEventListener("click", (_) => {
  play_tabs();
});

const update_note_sequence = (new_note_sequence) => {
  note_sequence = new_note_sequence;
  draw_tabs();
};

const is_natural_number = (n) => {
  const n1 = Math.abs(n);
  const n2 = parseInt(n, 10);

  return !isNaN(n1) && n1 === n2 && n1.toString() === n;
};

const is_valid_fret_number = (fret_number) => {
  return MIN_FRET <= fret_number && fret_number <= MAX_FRET;
};

const create_fretting_element = (fretting, index) => {
  const fretting_element = document.createElement("div");
  fretting_element.className = "fretting-element";

  for (let string of GUITAR_STRING_NAMES) {
    const string_fretting_control_element = document.createElement("button");
    string_fretting_control_element.className = "fretting-control";

    if (fretting[string] != undefined)
      string_fretting_control_element.textContent = fretting[string];

    string_fretting_control_element.onclick = () => {
      const new_fret = prompt("Choose new fret number:");

      if (
        new_fret != "" &&
        (!is_natural_number(new_fret) ||
          !is_valid_fret_number(parseInt(new_fret)))
      ) {
        alert("Invalid data!");
        return;
      }
      note_sequence[index][string] = new_fret != "" ? parseInt(new_fret) : "";
      draw_tabs();
    };

    fretting_element.appendChild(string_fretting_control_element);
  }

  return fretting_element;
};

const create_bar_element = (bar_index) => {
  const bar_element = document.createElement("div");
  bar_element.className = "bar";

  const remove_bar_button = document.createElement("button");
  remove_bar_button.className = "remove-bar";
  remove_bar_button.textContent = "X";
  remove_bar_button.onclick = () => {
    note_sequence.splice(bar_index * 4, 4);
    draw_tabs();
  };
  bar_element.appendChild(remove_bar_button);

  for (let i = 0; i < 4; ++i) {
    let fretting_index = bar_index * 4 + i;
    let fretting = note_sequence[fretting_index];

    bar_element.appendChild(create_fretting_element(fretting, fretting_index));
  }

  for (let i = 0; i < 6; ++i) {
    bar_element.appendChild(document.createElement("hr"));
  }

  if (bar_index % 2 == 0) {
    for (let string of GUITAR_STRING_NAMES) {
      const string_name_element = document.createElement("p");
      string_name_element.className = "string-name";
      string_name_element.innerText = string;
      bar_element.appendChild(string_name_element);
    }
  }

  return bar_element;
};

const draw_tabs = () => {
  // only quarter notes are supported currently
  const bars = Math.ceil(note_sequence.length / 4);

  // padding to fill the whole bar with notes
  for (let i = note_sequence.length; i < bars * 4; ++i) {
    note_sequence.push({});
  }

  tabs_container.innerHTML = "";

  for (let i = 0; i < bars; ++i) {
    tabs_container.appendChild(create_bar_element(i));
  }
};

const get_notes_from_fretting = (fretting) => {
  let notes = [];

  for (let string of Object.keys(fretting)) {
    notes.push(FRETBOARD_MAP[string][fretting[string]]);
  }

  return notes;
};

const style_current_notes = (quarter_note_index) => {
  if (quarter_note_index > 0) {
    const last_element = find_fretting_element(quarter_note_index - 1);
    last_element.className = "fretting-element";
  }

  const current_element = find_fretting_element(quarter_note_index);
  current_element.className = "fretting-element active";
};

const find_fretting_element = (quarter_note_index) => {
  const bar_index = Math.floor(quarter_note_index / 4);
  const bar = document.getElementsByClassName("bar")[bar_index];

  return bar.childNodes[(quarter_note_index % 4) + 1];
};

const play_tabs = () => {
  let delay = Tone.now();

  bpm_slider.disabled = true;
  for (let button of document.getElementsByTagName("button")) {
    button.disabled = true;
  }

  for (let i = 0; i < note_sequence.length; ++i) {
    Tone.Draw.schedule(() => {
      style_current_notes(i);
    }, delay);

    synth.triggerAttackRelease(
      get_notes_from_fretting(note_sequence[i]),
      "4n",
      delay
    );
    delay += Tone.Time("4n");
  }

  Tone.Draw.schedule(() => {
    if (note_sequence.length == 0) return;

    const fretting_element = find_fretting_element(note_sequence.length - 1);
    fretting_element.className = "fretting-element";

    for (let button of document.getElementsByTagName("button")) {
      button.disabled = false;
      bpm_slider.disabled = false;
    }
  }, delay);
};

draw_tabs();
