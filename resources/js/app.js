/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//import './bootstrap';
import '../css/app.css';


// App.js
import 'instantsearch.css/themes/satellite.css';
import { searchBox, hits, index } from 'instantsearch.js/es/widgets';
/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

const { algoliasearch, instantsearch } = window;
const { autocomplete } = window['@algolia/autocomplete-js'];
const { createLocalStorageRecentSearchesPlugin } = window[
  '@algolia/autocomplete-plugin-recent-searches'
];
const { createQuerySuggestionsPlugin } = window[
  '@algolia/autocomplete-plugin-query-suggestions'
];

const searchClient = algoliasearch('E4E85P59G2', 'b3171ba15e5f6b415e7bb0dddf1fba58');

const search = instantsearch({
  indexName: 'auctions',
  searchClient,
  future: { preserveSharedStateOnUnmount: true },
  insights: true,
});

const virtualSearchBox = instantsearch.connectors.connectSearchBox(() => {});

search.addWidgets([
  virtualSearchBox({}),
  instantsearch.widgets.hits({
    container: '#hits',
    templates: {
      item: (hit, { html, components }) => html`
<div class="card" id="item-card">
    <img id="item-image" src="${hit.image}" class="card-img-top mx-auto d-block" alt="...">
    <div class="card-body text-center">
    <div class="hit-name">
    ${components.Highlight({ hit, attribute: 'title' })}
    </div>
    <div class="hit-description">
        ${components.Highlight({ hit, attribute: 'description' })}
    </div>
        <a href="/auction/${hit.uuid}" class="btn btn-primary">View</a>
    </div>
</div>
`,
    },
  }),
  instantsearch.widgets.configure({
    hitsPerPage: 6,
  }),
  instantsearch.widgets.pagination({
    container: '#pagination',
  }),
]);

search.start();

const recentSearchesPlugin = createLocalStorageRecentSearchesPlugin({
  key: 'instantsearch',
  limit: 3,
  transformSource({ source }) {
    return {
      ...source,
      onSelect({ setIsOpen, setQuery, item, event }) {
        onSelect({ setQuery, setIsOpen, event, query: item.label });
      },
    };
  },
});

const querySuggestionsPlugin = createQuerySuggestionsPlugin({
  searchClient,
  indexName: 'auctions',
  getSearchParams() {
    return recentSearchesPlugin.data.getAlgoliaSearchParams({ hitsPerPage: 12 });
  },
  transformSource({ source }) {
    return {
      ...source,
      sourceId: 'querySuggestionsPlugin',
      onSelect({ setIsOpen, setQuery, event, item }) {
        onSelect({ setQuery, setIsOpen, event, query: item.query });
      },
      getItems(params) {
        if (!params.state.query) {
          return [];
        }

        return source.getItems(params);
      },
    };
  },
});

autocomplete({
  container: '#searchbox',
  openOnFocus: true,
  detachedMediaQuery: 'none',
  onSubmit({ state }) {
    setInstantSearchUiState({ query: state.query });
  },
  plugins: [recentSearchesPlugin, querySuggestionsPlugin],
});

function setInstantSearchUiState(indexUiState) {
  search.mainIndex.setIndexUiState({ page: 1, ...indexUiState });
}

function onSelect({ setIsOpen, setQuery, event, query }) {
  if (isModifierEvent(event)) {
    return;
  }

  setQuery(query);
  setIsOpen(false);
  setInstantSearchUiState({ query });
}

function isModifierEvent(event) {
  const isMiddleClick = event.button === 1;

  return (
    isMiddleClick ||
    event.altKey ||
    event.ctrlKey ||
    event.metaKey ||
    event.shiftKey
  );
}
