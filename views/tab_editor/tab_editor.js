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
const tabs_uploader = document.querySelector("#tabs-uploader");
const tabs_downloader = document.querySelector("#tabs-downloader");
const json_data_element = document.getElementById("json-data");
const user_id_form_element = document.getElementById("user-id");
const version_id_form_element = document.getElementById("version-id");
const version_data_form_element = document.getElementById("version-data");
const song_name_form_element = document.getElementById("song-name");
const song_author_form_element = document.getElementById("song-author");

// ACTUAL CODE
let bpm;
let note_sequence;
let can_edit;

const reader = new FileReader();
reader.addEventListener("load", (event) => {
  const new_song_data = JSON.parse(event.target.result);

  set_bpm(new_song_data.bpm);
  note_sequence = new_song_data.note_sequence;

  draw_tabs();
});

const synth = new Tone.PolySynth(Tone.Synth).toDestination();

const set_bpm = (new_bpm) => {
  bpm = new_bpm;
  Tone.getTransport().bpm.value = bpm;
  bpm_slider.value = bpm;
  value.textContent = bpm;
  version_data_form_element.value = JSON.stringify({ bpm, note_sequence });
};

tabs_downloader.addEventListener("click", () => {
  const blob = new Blob([JSON.stringify({ bpm, note_sequence })], {
    type: "application/json",
  });
  const url = URL.createObjectURL(blob);
  const a = document.createElement("a");
  a.href = url;
  a.download = `song.json`;
  a.click();
  URL.revokeObjectURL(url);
});

tabs_uploader.addEventListener("change", (_) => {
  if (tabs_uploader.files.length != 1) return;

  reader.readAsText(tabs_uploader.files[0]);
});

bpm_slider.addEventListener("input", (event) => {
  event.preventDefault();
  bpm = event.target.value;
  set_bpm(bpm);
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
      if (!can_edit) return;

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
  remove_bar_button.className =
    "remove-bar" + (can_edit ? "" : " dont-display");
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

  for (let string of GUITAR_STRING_NAMES) {
    const string_name_element = document.createElement("p");
    string_name_element.className =
      "string-name" + (bar_index % 2 == 1 ? " dont-display" : "");
    string_name_element.innerText = string;

    bar_element.appendChild(string_name_element);
  }

  for (let i = 0; i < 5; ++i) {
    const empty_fretting_insertor = document.createElement("button");
    empty_fretting_insertor.className =
      "empty-fretting-insertor" +
      (i == 4 && (bar_index + 1) * 4 < note_sequence.length
        ? " dont-display"
        : "") +
      (can_edit ? "" : " dont-display");
    empty_fretting_insertor.innerText = "V";
    empty_fretting_insertor.onclick = () => {
      if (!can_edit) return;
      note_sequence.splice(bar_index * 4 + i, 0, {});
      draw_tabs();
    };

    bar_element.appendChild(empty_fretting_insertor);
  }

  for (let i = 0; i < 4; ++i) {
    const fretting_deletor = document.createElement("button");
    fretting_deletor.className =
      "fretting-deletor" + (can_edit ? "" : " dont-display");
    fretting_deletor.innerText = "X";
    fretting_deletor.onclick = () => {
      if (!can_edit) return;
      note_sequence.splice(bar_index * 4 + i, 1);
      draw_tabs();
    };
    bar_element.appendChild(fretting_deletor);
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

  version_data_form_element.value = JSON.stringify({ bpm, note_sequence });
};

const get_notes_from_fretting = (fretting) => {
  let notes = [undefined];

  for (let string of Object.keys(fretting)) {
    notes.push(FRETBOARD_MAP[string][fretting[string]]);
  }

  return notes;
};

const scrollIntoViewWithOffset = (element, offset) => {
  window.scrollTo({
    behavior: 'smooth',
    top:
      element.getBoundingClientRect().top -
      document.body.getBoundingClientRect().top -
      offset,
  })
}

const style_current_notes = (quarter_note_index) => {
  if (quarter_note_index > 0) {
    const last_element = find_fretting_element(quarter_note_index - 1);
    last_element.className = "fretting-element";
  }

  const current_element = find_fretting_element(quarter_note_index);
  current_element.className = "fretting-element active";
  scrollIntoViewWithOffset(current_element, 32);
};

const find_fretting_element = (quarter_note_index) => {
  const bar_index = Math.floor(quarter_note_index / 4);
  const bar = document.getElementsByClassName("bar")[bar_index];

  return bar.childNodes[(quarter_note_index % 4) + 1];
};

const play_tabs = () => {
  if (note_sequence.length == 0) return;

  let delay = Tone.now();

  bpm_slider.disabled = true;
  for (let button of document.getElementsByTagName("button")) {
    button.disabled = true;
  }
  for (let input of document.getElementsByTagName("input")) {
    input.disabled = true;
  }
  document
    .getElementById("tabs-uploader-label")
    .classList.add("disabled-label");

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
    const fretting_element = find_fretting_element(note_sequence.length - 1);
    fretting_element.className = "fretting-element";

    bpm_slider.disabled = false;
    for (let button of document.getElementsByTagName("button")) {
      button.disabled = false;
    }
    for (let input of document.getElementsByTagName("input")) {
      input.disabled = false;
    }

    document
      .getElementById("tabs-uploader-label")
      .classList.remove("disabled-label");
  }, delay);
};

if (json_data_element != null) {
  const json_data = JSON.parse(json_data_element.textContent);
  console.log(json_data);

  can_edit = json_data.can_edit;
  // can_edit = true;
  song_name_form_element.value = json_data.song_name;
  song_author_form_element.value = json_data.song_author;
  version_id_form_element.value = json_data.version_id;
  if (json_data.version_data) {
    set_bpm(json_data.version_data.bpm);
    note_sequence = json_data.version_data.note_sequence;
  } else {
    set_bpm(60);
    note_sequence = [];
  }
  json_data_element.remove();
  draw_tabs();
} else {
  alert("ERROR");
}
