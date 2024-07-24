import { router } from '@inertiajs/react';
import { route } from 'ziggy-js';

export default function LanguageSwitcher() {
  const switchLanguage = (locale) => {
    router.get(
      route('language.switch', locale),
      {},
      {
        preserveState: false,
        preserveScroll: true,
        replace: true,
      }
    );
  };
  return (
    <div className="top-0 right-0 ">
      <button
        className=" text-gray-950 hover:text-gray-500 font-bold"
        onClick={() => switchLanguage('en')}
      >
        en
      </button>
      <span> / </span>
      <button
        className=" text-gray-950 hover:text-gray-500 font-bold"
        onClick={() => switchLanguage('ja')}
      >
        jp
      </button>
    </div>
  );
}
