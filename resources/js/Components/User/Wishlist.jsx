import { router } from '@inertiajs/react';
import { route } from 'ziggy-js';

export default function Wishlist({ wishlists = [], translations }) {
  const handleRemove = (id) => {
    if (
      confirm('Are you sure you want to remove this book from your wishlist?')
    ) {
      router.delete(route('wishlists.destroy', id), {
        preserveState: true,
        preserveScroll: true,
        only: ['wishlist', 'flash'],
      });
      // setSelectBook(null);
    }
  };

  return (
    <div className="bg-white shadow-md rounded-lg p-6 h-full flex flex-col">
      <h2 className="text-2xl font-bold mb-4">{translations.wishlist}</h2>
      {wishlists.length === 0 ? (
        <div className="flex-grow flex items-center justify-center">
          <p className="text-center text-gray-500">
            {translations.empty}
            <br />
            {translations.add}
          </p>
        </div>
      ) : (
        <ul className="overflow-y-auto flex-grow">
          {wishlists.map((item) => (
            <li
              key={item.id}
              className="mb-3 flex justify-between items-center border-b border-gray-200 pb-3 last:border-b-0 last:mb-0 last:pb-0"
            >
              <span className="mr-2 text-sm">
                <span className="font-semibold">{item.book.title}</span> by{' '}
                {item.book.author}
              </span>
              <button
                onClick={() => handleRemove(item.id)}
                className="bg-red-400 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-sm flex-shrink-0 transition duration-150 ease-in-out"
              >
                {translations.remove}
              </button>
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}
